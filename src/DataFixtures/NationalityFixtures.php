<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Nationalities's array to generate nationalities
        $nationalities = ['Français', 'Anglais', 'Espagnol', 'Portugais', 'Américain', 'Suisse', 'Belge'];

        foreach (range(1, 7) as $i) {
            $nationality = new Nationality();
            $nationality->setName($nationalities[$i - 1]);
            // $nationality->setNationality($this->getReference('nationality_' . rand(1, 5)));
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}