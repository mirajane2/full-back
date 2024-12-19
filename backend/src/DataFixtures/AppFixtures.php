<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this -> userPasswordHasher = $userPasswordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user -> setEmail("user@equipage.com");
        $user -> setRoles(["ROLE_USER"]);
        $user -> setPassword($this -> userPasswordHasher ->hashPassword($user,"password"));
        $manager -> persist($user);
        
        $manager->flush();
    }
}
