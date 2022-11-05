<?php

namespace App\Tests\Entity;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageTest extends KernelTestCase
{
    public function test_message_can_be_created(): void
    {
        self::bootKernel();

        // $routerService = static::getContainer()->get('router');
         $entityManager = static::getContainer()->get(EntityManagerInterface::class);


        $message = new Message();
        $message->setMessage('hello');
        $entityManager->persist($message);
        $entityManager->flush();

        $messageRecord = $entityManager->getRepository(Message::class)->findOneBy(['message' => 'hello']);

        $this->assertEquals('hello', $messageRecord->getMessage());


    }
}
