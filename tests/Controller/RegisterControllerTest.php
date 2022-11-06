<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{

    public function test_register_route_exists(){

        $client = static::createClient();
        $crawler = $client->request('POST', '/register');

        $this->assertResponseIsSuccessful();

    }
    public function test_user_can_register(): void
    {

        $client = static::createClient();
        $entityManager = static::getContainer()->get(UserRepository::class);

        $crawler = $client->request('POST', '/register');
        $buttonCrawlerNode = $crawler->selectButton('Register');
        $form = $buttonCrawlerNode->form();

        $name = $form->getName();

        $form[$name."[email]"] = 'b@gmail.com';
        $form[$name."[name]"] = 'cinnamon';
        $form[$name."[password]"] = '$2y$13$6SYanNxcPi56uP.dRSPr3.um.Ds0ooA73Fyi.PdYTgR9bPse8vQYC';


        $client->submit($form);

        $savedUser = $entityManager->findOneByEmail('b@gmail.com');

        $this->assertEquals('b@gmail.com', $savedUser->getEmail);
        $this->assertEquals('$2y$13$6SYanNxcPi56uP.dRSPr3.um.Ds0ooA73Fyi.PdYTgR9bPse8vQYC', $savedUser->getPassword);
        $this->assertEquals('cinnamon', $savedUser->getName);


    }
}
