<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Form\RegistrationType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setRoles(["ROLE_USER"]);
            $user->setScore(0);
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("security_login");
        }

        return $this->render('pages/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login()
    {
        return $this->render('pages/security/login.html.twig', ["error" => null]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }
}
