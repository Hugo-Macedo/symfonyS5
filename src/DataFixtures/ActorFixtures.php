<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 20) as $i) {
            $actor = new Actor();
            $actor->setFirstName('Actor' . $i);
            $actor->setLastName('Actor' . $i);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }
}