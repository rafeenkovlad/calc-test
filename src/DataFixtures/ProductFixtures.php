<?php


namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product1 = new Product();
        $product1->setCaption('Наушники');
        $product1->setCost(100);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setCaption('Чехол для телефона');
        $product2->setCost(20);
        $manager->persist($product2);

        $manager->flush();
    }
}