<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Challenge;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="homepage")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Challenge::class);

        $challenges = $repo->findAll();

        return $this->render('pages/home.html.twig', [
            'challenges' => $challenges
        ]);
    }
}
