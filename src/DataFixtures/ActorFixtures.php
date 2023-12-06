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

        foreach (range(1, 20) as $i) {
            $actor = new Actor();
            $actor->setFirstName($faker->firstName);
            $actor->setLastName($faker->lastName);
            // we add four actors to each movie
            for ($j = 1; $j <= 10; $j++) {
                $actor->setNationality($this->getReference('nationality_' . rand(1, 7)));
            }
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
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