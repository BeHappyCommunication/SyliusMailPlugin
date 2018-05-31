<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receiver', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.checkMail.receiver'
            ])
            ->add('title', TextType::class, [
                'label' => 'behappy_mail_plugin.ui.form.checkMail.title'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'behappy_mail_plugin.ui.form.checkMail.content'
            ]);
    }
}