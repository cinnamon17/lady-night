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

        //retrieve user from database
        $userRecord = $entityManager->getRepository(User::class)->findOneBy(['email' => 'a@gmail.com']);

        //relate user to gift setting user_id field
        $gift->setUsers($userRecord);


        $entityManager->persist($gift);
        $entityManager->flush();

        $giftRecord = $entityManager->getRepository(Gift::class)->findOneBy(['users' => $userRecord->getId()]);

        $this->assertEquals(2, $giftRecord->getFires());
        $this->assertEquals(5, $giftRecord->getHearts());
        $this->assertEquals(8, $giftRecord->getKisses());

    }
}
