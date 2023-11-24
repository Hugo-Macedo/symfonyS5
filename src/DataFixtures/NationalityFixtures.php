<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 20) as $i) {
            $nationality = new Nationality();
            $nationality->setName('Nationality' . $i);
            // $nationality->setNationality($this->getReference('nationality_' . rand(1, 5)));
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}