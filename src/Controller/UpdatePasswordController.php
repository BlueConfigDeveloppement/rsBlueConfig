<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UpdatePasswordController extends AbstractController
{
    #[Route('/updatepassword/{id}', name: 'update_password')]
    public function indexupdatePassword(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('update_password' , array(
                'id' => $user->getId(),
                ));
        }

        return $this->render('update_password/index.html.twig', [
            'controller_name' => 'UpdatePasswordController',
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
