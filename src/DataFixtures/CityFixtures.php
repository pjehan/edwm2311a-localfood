<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rennes = new City();
        $rennes->setName('Rennes');
        $rennes->setZipCode('35000');
        $manager->persist($rennes);
        $this->addReference('rennes', $rennes);

        $paris = new City();
        $paris->setName('Paris');
        $paris->setZipCode('75000');
        $manager->persist($paris);
        $this->addReference('paris', $paris);

        $nantes = new City();
        $nantes->setName('Nantes');
        $nantes->setZipCode('44000');
        $manager->persist($nantes);
        $this->addReference('nantes', $nantes);

        $lyon = new City();
        $lyon->setName('Lyon');
        $lyon->setZipCode('69000');
        $manager->persist($lyon);
        $this->addReference('lyon', $lyon);

        $manager->flush();
    }
}
