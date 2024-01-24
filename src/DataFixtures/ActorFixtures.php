<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Person($faker));

        $actors = $faker->actors($gender = null, $count = 190, $duplicates = false);
        $createdActors= [];

        foreach ($actors as $key=>$item) {
            $fullname = $item; //ex : Christian Bale
            $fullnameExploded = explode(' ', $fullname);
            $firstname = $fullnameExploded[0]; //ex : Christian
            $lastname = $fullnameExploded[1]; //ex : Bale

            $actor = new Actor();
            $actor->setFirstName($firstname);
            $actor->setLastName($lastname);
            // we add four actors to each movie
            for ($j = 1; $j <= 10; $j++) {
                $actor->setNationality($this->getReference('nationality_' . rand(1, 7)));
            }

            $createdActors[] = $actor;
            $manager->persist($actor);
            $this->addReference('actor_' . $key+1, $actor);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
        ];
    }
}