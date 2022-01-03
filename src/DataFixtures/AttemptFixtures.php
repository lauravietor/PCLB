<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\ChallengeFixtures;
use App\Entity\Attempt;

// require_once 'vendor/autoload.php';

class AttemptFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 0; $i < 300; $i++) {
            $attempt = new Attempt();

            $usersQuery = $manager->createQuery('SELECT u FROM App\Entity\User u');
            $users = $usersQuery->getResult();
            $attemptedBy = $faker->randomElement($users);

            $challengesQuery = $manager->createQuery('SELECT c FROM App\Entity\Challenge c');
            $challenges = $challengesQuery->getResult();
            $challenge = $faker->randomElement($challenges);

            $challengeDate = $challenge->getCreatedOn();

            $attemptedOn = $faker->dateTime($challengeDate);

            $answer = $faker->regexify('[A-Za-z0-9]{6,10}');

            $attempt->setAttemptedBy($attemptedBy)
                    ->setChallenge($challenge)
                    ->setAttemptedOn($attemptedOn)
                    ->setAttempt($answer);

            $manager->persist($attempt);
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
