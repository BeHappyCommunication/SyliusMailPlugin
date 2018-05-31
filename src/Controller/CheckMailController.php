<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Controller;

use BeHappy\SyliusMailPlugin\Entity\Mail;
use BeHappy\SyliusMailPlugin\Entity\MailConfiguration;
use BeHappy\SyliusMailPlugin\Form\Type\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckMailController extends Controller
{
    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkMailAction(Request $request, int $id)
    {
        $configuration = $this->getDoctrine()->getRepository(MailConfiguration::class)->find($id);

        if (!$configuration instanceof MailConfiguration) {
            throw new NotFoundHttpException();
        }

        $mail = new Mail();
        $mail->setConfiguration($configuration);
        $form = $this->createForm(MailType::class, $mail);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->get('sylius.email_sender')->send('test_mail', [$mail->getReceiver()], ['mail' => $mail]);
            
                $this->addFlash('success', 'Message envoyé');
            } else {
                $this->addFlash('error', 'Erreur. Formulaire invalide');
            }
        }

        return $this->render('@BeHappySyliusMailPlugin/Resources/views/check_mail/check_mail.html.twig', [
            'form' => $form->createView()
        ]);
    }
}