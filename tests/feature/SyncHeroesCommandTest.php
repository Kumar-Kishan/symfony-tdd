<?php

namespace App\Tests\Feature;

use App\Entity\Hero;
use App\Tests\DatabaseDependentTestCase;
use App\Tests\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SyncHeroesCommandTest extends DatabaseDependentTestCase
{

    /** @test */
    public function CanSyncHeroes()
    {
        $application = new Application(self::$kernel);

        $command = $application->find("app:sync-heroes");

        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $repo = $this->entityManager->getRepository(Hero::class);

        $heroes = $repo->findAll([]);

        $this->assertGreaterThan(1558, count($heroes));
    }
}
