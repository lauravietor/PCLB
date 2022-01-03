<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\DataFixtures\UserFixtures;
use App\Entity\Challenge;

// require_once 'vendor/autoload.php';

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=0; $i<10; $i++) {
            $challenge = new Challenge();

            $name = $faker->sentence(3, false);
            $description = $faker->text($faker->numberBetween(1000, 1500));
            $password = $faker->regexify('[A-Za-z]{6,10}');
            $reward = $faker->numberBetween(10, 50) * 10;
            $createdOn = $faker->dateTime();
            $difficulty = $faker->numberBetween(1, 10);

            $query = $manager->createQuery('SELECT u FROM App\Entity\User u');
            $users = $query->getResult();

            $createdBy = $faker->randomElement($users);

            $challenge->setName($name)
                      ->setDescription($description)
                      ->setPassword($password)
                      ->setReward($reward)
                      ->setCreatedOn($createdOn)
                      ->setDifficulty($difficulty)
                      ->setCreatedBy($createdBy);

            $manager->persist($challenge);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
