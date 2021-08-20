<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@dev');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, '!aTFEPHom9'));

        $userAdmin = new User();
        $userAdmin->setEmail('admin@dev');
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->passwordEncoder->encodePassword($userAdmin, '!aTFEPHom9'));
        
        $manager->persist($user);
        $manager->persist($userAdmin);
        $manager->flush();
    }
}
