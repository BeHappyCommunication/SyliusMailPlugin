<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Form\Type;

use BeHappy\SyliusMailPlugin\Entity\MailConfiguration;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Model\Channel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MailConfigurationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build your custom form, with all fields that you need
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'behappy_mail_plugin.ui.form.send_type',
                'choices' => MailConfiguration::TYPE
            ])
            ->add('smtpHost', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.smtpHost',
                'required' => false
            ])
            ->add('smtpPort', NumberType::class, [
                'label' => 'behappy_mail_plugin.ui.form.smtpPort',
                'required' => false
            ])
            ->add('smtpUser', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.smtpUser',
                'required' => false
            ])
            ->add('smtpPassword', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.smtpPassword',
                'required' => false
            ])
            ->add('dkim', CheckboxType::class, [
                'label' => 'behappy_mail_plugin.ui.form.dkim',
                'required' => false
            ])
            ->add('dkimDomain', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.dkim_domain',
                'required' => false,
            ])
            ->add('dkimSelector', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.dkim_selector',
                'required' => false,
            ])
            ->add('dkimKey', TextareaType::class, [
                'label' => 'behappy_mail_plugin.ui.form.dkim_key',
                'required' => false,
            ])
            ->add('senderName', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.senderName'
            ])
            ->add('senderMail', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.senderMail'
            ])
            ->add('replyToMail', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.replyToMail',
                'required' => false
            ])
            ->add('encryption', ChoiceType::class, [
                'label' => 'behappy_mail_plugin.ui.form.encryption_type',
                'choices' => MailConfiguration::ENCRYPTION,
                'required' => false
            ])
            ->add('channels', EntityType::class, [
                'label' => 'behappy_mail_plugin.ui.form.channels',
                'class' => Channel::class,
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'behappy_mail_plugin_mail_configuration';
    }
}
