<?php

namespace App\Command;

use App\Entity\Hero;
use App\Http\MarvelApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncHeroesCommand extends Command
{


    private EntityManagerInterface $entityManager;

    private MarvelApiClient $marvelApiClient;




    public function __construct(EntityManagerInterface $entityManager, MarvelApiClient $marvelApiClient)
    {
        $this->entityManager = $entityManager;
        $this->marvelApiClient = $marvelApiClient;
        parent::__construct();
    }


    protected static $defaultName = 'app:sync-heroes';
    protected static $defaultDescription = 'Synchronizes heroes from third-party api';

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->entityManager->createQuery(
            'DELETE FROM App\Entity\Hero'
        )->execute();

        $count = 0;
        foreach ($this->marvelApiClient->getHeroes() as $hero) {
            $h =  new Hero();
            $h->setName($hero->name);
            $h->setImage($hero->thumbnail->path);
            $this->entityManager->persist($h);
            $count++;
            if ($count % 100 == 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
        return Command::SUCCESS;
    }
}
