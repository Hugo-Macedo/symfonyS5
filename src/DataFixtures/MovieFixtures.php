<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ActorFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        $movies = $faker->movies(100);
        foreach ($movies as $item) {
            $movie = new Movie();
            //Generate a title with 3 random words
            $movie->setTitle($item); 
            $movie->setDescription($faker->paragraph);
            // Generate a releaseDate with a DateTime in 21th century
            $movie->setReleaseDate($faker->dateTimeThisCentury);
            // Generate a duration with a random number between 60 and 180
            $movie->setDuration($faker->numberBetween(60, 180));
            $movie->setCategory($this->getReference('category_'.rand(1, 6)));
            $movie->setOnline(true);

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