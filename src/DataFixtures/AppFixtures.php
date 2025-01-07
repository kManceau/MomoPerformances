<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\Page;
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
        $admin->setHasAvatar(false);
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('JeanClaude');
        $user->setEmail('jean@claude.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'JeanClaude'));
        $user->setRoles(['ROLE_USER']);
        $user->setHasAvatar(false);
        $manager->persist($user);

        $page = new Page();
        $page->setTitle('index');
        $page->setContent('
        <section id="hero" class="py-5">
        <div class="container-lg text-center text-white">
            <h1 class="mb-3 hero-text">MomoPerformances</h1>
            <p class="h3 hero-text">Votre partenaire en reprogrammation moteur</p>
        </div>
    </section>

    <section id="presentation">
        <div class="text-content container-lg text-white text-center py-5">
            <h2 class="mb-5">Faites confiance à MomoPerformances pour une expérience de conduite incomparable et des performances optimales.</h2>
            <p>Bienvenue chez MomoPerformances, l\'expert incontournable en reprogrammation moteur. Spécialistes dans
                l\'optimisation de la performance des véhicules, nous modifions les paramètres des puces de moteurs pour
                maximiser la puissance, l\'efficacité énergétique et la durabilité de votre véhicule.</p>
            <p>Grâce à notre expertise et à notre savoir-faire, nous analysons et reprogrammons les fichiers de
                paramétrage des moteurs, garantissant des résultats exceptionnels et personnalisés pour chaque client.
    Que vous cherchiez à améliorer les performances de votre voiture de sport, de votre véhicule utilitaire
                ou de votre camion, MomoPerformances s\'engage à vous fournir un service sur mesure et de haute
                qualité.</p>
            <p>Notre mission est de repousser les limites de votre moteur tout en respectant les normes
                environnementales et de sécurité.</p>
        </div>
    </section>');
        $manager->persist($page);
        $manager->flush();
    }
}
