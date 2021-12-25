<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

require_once 'vendor/autoload.php';

function formatName(string $nameToFormat): String
{
    return strtolower(strtr(iconv("UTF-8", "ASCII//TRANSLIT", $nameToFormat), ' ', '-'));
}

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++) {

            $user = new User();

            $firstName = $faker->firstName();
            $lastName = $faker->lastName();

            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            $firstName = formatName($firstName);
            $lastName = formatName($lastName);

            $username = $firstName[0] . $lastName;
            $email = "{$firstName}.{$lastName}@centrale-marseille.fr";

            $roles = ['ROLE_USER'];
            if($i == 1) {
                $roles = array_merge($roles, ['ROLE_ADMIN']);
            }

            $user->setUsername($username)
                 ->setEmail($email)
                 ->setPassword($faker->regexify('[A-Za-z0-9_-]{8,32}'))
                 ->setScore($faker->numberBetween(0, 100) * 10)
                 ->setRoles($roles);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
