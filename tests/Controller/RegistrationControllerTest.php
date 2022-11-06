<?php

namespace App\Tests\Controller;

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

        $crawler = $client->request('GET', '/register');

        $client->followRedirects();

        $buttonCrawlerNode = $crawler->selectButton('Register');
        $form = $buttonCrawlerNode->form();

        $name = $form->getName();

        $form[$name."[email]"] = 'b@gmail.com';
        $form[$name."[name]"] = 'cinnamon';
        $form[$name."[plainPassword]"] = '$2y$13$6SYanNxcPi56uP.dRSPr3.um.Ds0ooA73Fyi.PdYTgR9bPse8vQYC';
        $form[$name."[agreeTerms]"] = '1';

        $client->followRedirects();

        $client->submit($form);

        $this->assertResponseIsSuccessful();

        $userData = $entityManager->findOneBy(['email' => 'b@gmail.com']);

        $this->assertEquals('b@gmail.com', $userData->getEmail());
        $this->assertEquals('cinnamon', $userData->getName());

    }
}
