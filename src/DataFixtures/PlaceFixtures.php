<?php

namespace App\DataFixtures;

use App\Entity\Place;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $clarisseGarden = new Place();
        $clarisseGarden->setName('Jardin de Clarisse');
        $clarisseGarden->setDescription('Un jardin magnifique où il fait bon se promener');
        $clarisseGarden->setType(Type::Producer);
        $clarisseGarden->setOwner($this->getReference('john_doe'));
        $clarisseGarden->addCategory($this->getReference('fruits_and_vegetables'));
        $clarisseGarden->addCategory($this->getReference('meat_and_fish'));
        $manager->persist($clarisseGarden);

        $janeBakery = new Place();
        $janeBakery->setName('Boulangerie de Jane');
        $janeBakery->setDescription('Une boulangerie où l\'on trouve les meilleurs pains de la ville');
        $janeBakery->setType(Type::PointOfSale);
        $janeBakery->setOwner($this->getReference('jane_doe'));
        $janeBakery->addCategory($this->getReference('dairy_products'));
        $janeBakery->addCategory($this->getReference('drinks'));
        $manager->persist($janeBakery);

        $janeOrchard = new Place();
        $janeOrchard->setName('Verger de Jane');
        $janeOrchard->setDescription('Un verger où l\'on peut cueillir des fruits et des légumes');
        $janeOrchard->setType(Type::Producer);
        $janeOrchard->setOwner($this->getReference('jane_doe'));
        $janeOrchard->addCategory($this->getReference('fruits_and_vegetables'));
        $manager->persist($janeOrchard);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}
