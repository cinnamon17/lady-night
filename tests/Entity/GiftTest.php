<?php

namespace App\Tests\Entity;

use App\Entity\Gift;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GiftTest extends KernelTestCase
{
    public function test_gift_can_be_created_in_database(): void
    {
        self::bootKernel();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gift = new Gift();
        $gift->setFires(2);
        $gift->setHearts(5);
        $gift->setKisses(8);

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
        $gift->setUsers($user);

        $entityManager->persist($gift);
        $entityManager->persist($user);

        $entityManager->flush();

        $giftRecord = $entityManager->getRepository(Gift::class)->findOneBy(['users' => $user->getId()]);

        $this->assertEquals(2, $giftRecord->getFires());
        $this->assertEquals(5, $giftRecord->getHearts());
        $this->assertEquals(8, $giftRecord->getKisses());

    }
}
