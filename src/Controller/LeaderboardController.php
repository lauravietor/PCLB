<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\User;

/**
 * Require authentification to see other users
 *
 * @IsGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class LeaderboardController extends AbstractController
{
    /**
     * @Route("/leaderboard", name="leaderboard")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $users = $repo->findAll();

        usort($users, function ($user1, $user2) {
            return $user2->getScore() - $user1->getScore();
        });

        return $this->render('pages/leaderboard.html.twig', [
            'users' => $users
        ]);
    }
}

