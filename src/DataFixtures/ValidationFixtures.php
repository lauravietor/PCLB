<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\ChallengeFixtures;
use App\Entity\Validation;

class ValidationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++) {
            $validation = new Validation();

            $usersQuery = $manager->createQuery('SELECT u FROM App\Entity\User u');
            $users = $usersQuery->getResult();
            $createdBy = $faker->randomElement($users);

            $challengesQuery = $manager->createQuery('SELECT c FROM App\Entity\Challenge c');
            $challenges = $challengesQuery->getResult();
            $challenge = $faker->randomElement($challenges);

            $curr_score = $createdBy->getScore();
            $chall_reward = $challenge->getReward();

            $createdBy->setScore($curr_score + $chall_reward);

            $challengeDate = $challenge->getCreatedOn();

            $validatedOn = $faker->dateTime($challengeDate);

            $feedback = $faker->numberBetween(1, 10);

            $validation->setCreatedBy($createdBy)
                       ->setChallenge($challenge)
                       ->setValidatedOn($validatedOn)
                       ->setFeedback($feedback);

            $manager->persist($validation);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ChallengeFixtures::class,
        ];
    }
}
