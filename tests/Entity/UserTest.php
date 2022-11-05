<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{

    public function test_user_can_be_created_in_database(): void
    {

        self::bootKernel();

        $container = static::getContainer();

        $em = $container->get(EntityManagerInterface::class);

        $user = new User();
        $user->setEmail('asd@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('asd');
        $user->setInterests('I love soup');
        $user->setName('juan');
        $user->setProfilePicture('www.google.com');
        $user->setProfilePictureSecond('www.google.com');
        $user->setProfilePictureThird('www.google.com');
        $user->setTokens('100');

        $em->persist($user);

        $em->flush();

        $userRepository = $em->getRepository(User::class);

        $userRecord = $userRepository->findOneBy(['email' => 'asd@gmail.com']);

        $this->assertEquals('asd@gmail.com', $userRecord->getEmail());
        $this->assertEquals([0 =>'ROLE_USER'], $userRecord->getRoles());
        $this->assertEquals('asd', $userRecord->getPassword());
        $this->assertEquals('I love soup', $userRecord->getInterests());
        $this->assertEquals('juan', $userRecord->getName());
        $this->assertEquals('www.google.com', $userRecord->getProfilePicture());
        $this->assertEquals('www.google.com', $userRecord->getProfilePictureSecond());
        $this->assertEquals('www.google.com', $userRecord->getProfilePictureThird());
        $this->assertEquals('100', $userRecord->getTokens());

    }
}
