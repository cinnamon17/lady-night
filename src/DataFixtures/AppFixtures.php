<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('a@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('asd');
        $user->setInterests('I love soup');
        $user->setName('juan');
        $user->setProfilePicture('www.google.com');
        $user->setProfilePictureSecond('www.google.com');
        $user->setProfilePictureThird('www.google.com');
        $user->setTokens('100');

        $manager->persist($user);

        $manager->flush();

    }
}
