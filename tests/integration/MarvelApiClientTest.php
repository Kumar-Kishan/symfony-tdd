<?php

namespace App\Tests\Integration;

use App\Tests\DatabaseDependentTestCase;

class MarvelApiClientTest extends DatabaseDependentTestCase{
    /** 
     * @test
     * @group integration 
     */
    public function MarvelApiClientReturnsCharacters(){
        $marvelApiClient = self::$kernel->getContainer()->get('marvel-api-client');
        $heroes = $marvelApiClient->getHeroes();
        $this->assertGreaterThan(1558, count($heroes));
    }

}