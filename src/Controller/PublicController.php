<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;

class PublicController extends AbstractController
{
    #[Route('/', name: 'public')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
    #[Route('admin/', name: 'admintest')]
    public function admin(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
    #[Route('profile/', name: 'profiletest')]
    public function test(): Response
    {
        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
    
        $form = $this->createForm(ContactType::class, null);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new Email())
            ->from(new Address('noreply@essaiswebnet.fr', 'Contact Mon Site')) // Adresse d'envoi de notre serveur
            ->to(new Address('glessmer@live.fr', 'Blue Config' ))// Adresse adminContact
            ->replyTo(new Address($form->get('email')->getData(), $form->get('nom')->getData().' '.$form->get('prenom')->getData())) // Adresse indiqué par le contact pour lui repondre directement
            ->subject($form->get('objet')->getData())
            // ->text('Sending emails is fun again!')
            ->html('<h1>Message Contact Site</h1><h2>De: '.$form->get('nom')->getData().' '.$form->get('prenom')->getData().'</h2><h3> email: '.$form->get('email')->getData().'</h3><p>'.$form->get('message')->getData().'</p>');

        $mailer->send($email);
        }

        return $this->render('public/contact.html.twig', [
            'controller_name' => 'Page contact',
            'form'=>$form->createView(),
        ]);
    }
}
