<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername("test");
        $user->setApiToken("test_token");
        $user->setPassword("testpw");
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        $manager->flush();
    }
}
