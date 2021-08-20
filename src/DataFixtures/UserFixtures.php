<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('user@dev')
            ->setRoles(["ROLE_USER"])
            ->setPassword('!aTFEPHom9')
        ;

        $userAdmin = (new User())
            ->setEmail('admin@dev')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword('!aTFEPHom9')
        ;
        
        $manager->persist($user);
        $manager->persist($userAdmin);
        $manager->flush();
    }
}
