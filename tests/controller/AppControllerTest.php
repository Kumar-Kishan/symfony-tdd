<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppControllerTest extends WebTestCase
{

    /** @test */
    public function CannotVisitWithoutApiKey(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(401);
    }

    /** @test */
    public function CannotVisitWithWrongApiKey(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/', [], [], [
            'HTTP_X-AUTH-TOKEN'  => 'test_token_w',
        ]);

        $this->assertResponseStatusCodeSame(401);
    }


    /** @test */
    public function CanVisitWithCorrectApiKey(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/', [], [], [
            'HTTP_X-AUTH-TOKEN' => 'test_token',
        ]);
        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(1559, count($response));
    }
}
