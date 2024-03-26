<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fruitsAndVegetables = new Category();
        $fruitsAndVegetables->setName('Fruits et légumes');
        $manager->persist($fruitsAndVegetables);
        $this->addReference('fruits_and_vegetables', $fruitsAndVegetables);

        $meatAndFish = new Category();
        $meatAndFish->setName('Viandes et poissons');
        $manager->persist($meatAndFish);
        $this->addReference('meat_and_fish', $meatAndFish);

        $dairyProducts = new Category();
        $dairyProducts->setName('Produits laitiers');
        $manager->persist($dairyProducts);
        $this->addReference('dairy_products', $dairyProducts);

        $drinks = new Category();
        $drinks->setName('Boissons');
        $manager->persist($drinks);
        $this->addReference('drinks', $drinks);

        $manager->flush();
    }
}
