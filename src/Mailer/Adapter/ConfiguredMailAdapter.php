<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Mailer\Adapter;

use BeHappy\SyliusMailPlugin\Entity\MailConfiguration;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Mailer\Event\EmailSendEvent;
use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\Adapter\AbstractAdapter;
use Sylius\Component\Mailer\SyliusMailerEvents;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ConfiguredMailAdapter extends AbstractAdapter implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;
    
    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    /**
     * @param array          $recipients
     * @param string         $senderAddress
     * @param string         $senderName
     * @param RenderedEmail  $renderedEmail
     * @param EmailInterface $email
     * @param array          $data
     * @param array          $attachments
     * @param array          $replyTo
     */
    public function send(array $recipients, string $senderAddress, string $senderName, RenderedEmail $renderedEmail,
                         EmailInterface $email, array $data, array $attachments = [], array $replyTo = []): void
    {
        /** @var Channel $channel */
        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $em = $this->container->get('doctrine')->getManager();
        /** @var MailConfiguration $configuration */
        $configuration = $em->getRepository(MailConfiguration::class)->findOneByChannel($channel);
        
        $message = (new \Swift_Message())
            ->setSubject($renderedEmail->getSubject())
            ->setFrom([$senderAddress => $senderName])
            ->setTo($recipients)
            ->setReplyTo($replyTo);
        
        $message->setBody($renderedEmail->getBody(), 'text/html');
        
        foreach ($attachments as $attachment) {
            $file = \Swift_Attachment::fromPath($attachment);
            
            $message->attach($file);
        }
        
        $emailSendEvent = new EmailSendEvent($message, $email, $data, $recipients, $replyTo);
        
        $this->dispatcher->dispatch(SyliusMailerEvents::EMAIL_PRE_SEND, $emailSendEvent);
        
        //Select transport mode depending on configuration
        $sendingType = $configuration->getType();
        switch ($sendingType) {
            case MailConfiguration::TYPE_SMTP:
                //TODO: Test/Debug SMTP Method
                $transport = new \Swift_SmtpTransport(
                    $configuration->getSmtpHost(),
                    $configuration->getSmtpPort(),
                    ($configuration->getEncryption() === MailConfiguration::ENCRYPTION_TLS ? 'tls' : 'ssl')
                );
                $transport
                    ->setUsername($configuration->getSmtpUser())
                    ->setPassword($configuration->getSmtpPassword())
                    ->setTimeout(5);
                $this->mailer = new \Swift_Mailer($transport);
                break;
            case MailConfiguration::TYPE_DIRECT:
            default:
                break;
        }
        
        $this->mailer->send($message);
        $this->dispatcher->dispatch(SyliusMailerEvents::EMAIL_POST_SEND, $emailSendEvent);
    }
}