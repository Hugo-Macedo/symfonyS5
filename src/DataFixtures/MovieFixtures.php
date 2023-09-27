<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ActorFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 40) as $i) {
            $movie = new Movie();
            $movie->setTitle('Movie ' . $i);
            $movie->setReleaseDate(rand(1980, 2023));
            $movie->setDuration(rand(60, 180));
            $movie->setDescription('Synopsis ' . $i);
            $movie->setCategory($this->getReference('category_' . rand(1, 5)));

            $actors = [];
            foreach (range(1, rand(2, 6)) as $i) {
                $actor = $this->getReference('actor_' . rand(1, 20));
                if (!in_array($actor, $actors)) {
                    $actors[] = $actor;
                    $movie->addActor($actor);
                }
            }

            $manager->persist($movie);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            ActorFixtures::class,
        ];
    }
}