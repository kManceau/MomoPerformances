<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties] class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('KevinManceau');
        $admin->setEmail('kevin.manceau@gmail.com');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'KevinManceau'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('JeanClaude');
        $user->setEmail('jean@claude.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'JeanClaude'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
