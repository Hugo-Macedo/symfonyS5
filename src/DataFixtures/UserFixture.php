<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct( protected UserPasswordHasherInterface $passwordHasherInterface)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Create an admin
        $userAdmin = new User();
        $userAdmin->setEmail('admin@gmail.com');
        $userAdmin->setPassword($this->passwordHasherInterface->hashPassword($userAdmin, 'admin'));
        $userAdmin->setRoles(['ROLE_ADMIN']);

        $manager->persist($userAdmin);


        $user_name = ['Baptiste', 'Erwan', 'Paul', 'Oscar'];
        // create 4 users
        for ($i = 0; $i < 4; $i++) {
            $user = new User();
            $user->setEmail(strtolower($user_name[$i].'@gmail.com'));
            $user->setPassword($this->passwordHasherInterface->hashPassword($user, 'user'.$i));
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
        }
        $manager->flush();
    }
}
