<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Event\Subscriber;

use BeHappy\SyliusMailPlugin\Entity\MailConfiguration;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Mailer\Event\EmailSendEvent;
use Sylius\Component\Mailer\SyliusMailerEvents;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MailerSubscriber
 *
 * @package BeHappy\MailPlugin\Event\Subscriber
 */
class MailerSubscriber implements EventSubscriberInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    /**
     * MailerSubscriber constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }
    
    /**
     * @return array
     */
    public static function getSubScribedEvents(): array
    {
        return [
            SyliusMailerEvents::EMAIL_PRE_SEND => 'preSend',
        ];
    }
    
    /**
     * @param EmailSendEvent $event
     *
     * @throws \Swift_SwiftException
     */
    public function preSend(EmailSendEvent $event): void
    {
        /** @var Channel $channel */
        $channel = $this->container->get('sylius.context.channel')->getChannel();
        $em = $this->container->get('doctrine')->getManager();
        /** @var MailConfiguration $configuration */
        $configuration = $em->getRepository(MailConfiguration::class)->findOneByChannel($channel);
        /** @var \Swift_Message $message */
        $message = $event->getMessage();
        
        $message->setFrom($configuration->getSenderMail(), $configuration->getSenderName());
        
        if (!empty($configuration->getReplyToMail())) {
            $emailValidator = new EmailValidator();
            if ($emailValidator->isValid($configuration->getReplyToMail(), new RFCValidation())) {
                $message->addReplyTo($configuration->getReplyToMail());
            }
        }
        
        if ($configuration->isDkim()) {
            if (!$configuration->isDkimReady()) {
                throw new \LogicException('Missing fields for DKIM sending');
            }
            $signer = $this->getDkimSigner($configuration->getDkimKey(), $configuration->getDkimDomain(), $configuration->getDkimSelector());
            $message->attachSigner($signer);
        }
    }
    
    /**
     * @param string $dkimKey
     * @param string $domainName
     * @param string $selector
     *
     * @return \Swift_Signers_DKIMSigner
     * @throws \Swift_SwiftException
     */
    protected function getDkimSigner(string $dkimKey, string $domainName, string $selector): \Swift_Signers_DKIMSigner
    {
        $signer = new \Swift_Signers_DKIMSigner($dkimKey, $domainName, $selector);
        
        $signer->setBodyCanon('relaxed')
            ->setHeaderCanon('relaxed')
            ->setHashAlgorithm('rsa-sha256');
        
        return $signer;
    }
}