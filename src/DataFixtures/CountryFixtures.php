<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $country1 = new Country();
        $country1->setCode('DE');
        $country1->setName('Германия');
        $country1->setTax(19.0);
        $manager->persist($country1);

        $country2 = new Country();
        $country2->setCode('IT');
        $country2->setName('Италия');
        $country2->setTax(22.0);
        $manager->persist($country2);

        $country3 = new Country();
        $country3->setCode('GR');
        $country3->setName('Греция');
        $country3->setTax(24.0);
        $manager->persist($country3);

        $manager->flush();
    }
}