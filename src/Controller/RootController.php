<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Challenge;

class RootController extends AbstractController
{
    /**
     * @Route("/", name="root")
     */
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute("homepage");
    }
}

