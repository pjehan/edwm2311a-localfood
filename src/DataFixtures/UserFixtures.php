<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('pierre.jehan@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        $johnDoe = new User();
        $johnDoe->setEmail('john.doe@gmail.com');
        $johnDoe->setRoles(['ROLE_USER']);
        $johnDoe->setPassword($this->passwordEncoder->hashPassword($johnDoe, 'john'));
        $manager->persist($johnDoe);
        $this->addReference('john_doe', $johnDoe);

        $janeDoe = new User();
        $janeDoe->setEmail('jane.doe@gmail.com');
        $janeDoe->setRoles(['ROLE_USER']);
        $janeDoe->setPassword($this->passwordEncoder->hashPassword($janeDoe, 'jane'));
        $manager->persist($janeDoe);
        $this->addReference('jane_doe', $janeDoe);

        $manager->flush();
    }
}
