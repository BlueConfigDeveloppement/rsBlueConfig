<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfil;
use App\Form\UserProfilType;
use App\Repository\UserProfilRepository;
use App\Security\EmailVerifier;
use App\Services\BreadcrumdServices;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#[Route('back_office/user-profil')]
class UserProfilController extends AbstractController
{
    private $breadcrumbServices;

    public function __construct(BreadcrumdServices $breadcrumbServices)
    {
        $this->breadcrumbServices = $breadcrumbServices;
    }

    #[Route('/', name: 'user_profil_index', methods: ['GET'])]
    public function index(UserProfilRepository $userProfilRepository): Response
    {
        // Génération Breadcrump -> Sercices
        $this->breadcrumbServices->createdRouteLibelle(['user-profil','UserProfil'], 'Index', 'Page des utilisateurs');
        $breadcrumb = $this->breadcrumbServices->createdBreadcrumbAdmin();

        return $this->render('user_profil/index.html.twig', [
            'user_profils' => $userProfilRepository->findAll(),
            'breadcrumd' => $breadcrumb,
        ]);
    }

    #[Route('/new', name: 'user_profil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailVerifier $emailVerifier): Response
    {
        $userProfil = new UserProfil();
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('email')->getData()){
                $user = new User();
                $user->setEmail($form->get('email')->getData());
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // generate a signed url and email it to the user
                $emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                        ->from(new Address('noreply@blueteach.fr', 'Projet'))
                        ->to($user->getEmail())
                        ->subject('Please Confirm your Email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );
                // do anything else you need here, like send an email
                $userProfil->setUser($user);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userProfil);
            $entityManager->flush();


            return $this->redirectToRoute('user_profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_profil/new.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_profil_show', methods: ['GET'])]
    public function show(UserProfil $userProfil): Response
    {
        return $this->render('user_profil/show.html.twig', [
            'user_profil' => $userProfil,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserProfil $userProfil): Response
    {
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_profil/edit.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_profil_delete', methods: ['POST'])]
    public function delete(Request $request, UserProfil $userProfil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userProfil->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userProfil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_profil_index', [], Response::HTTP_SEE_OTHER);
    }
}
