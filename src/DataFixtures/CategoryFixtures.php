<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\DataFixtures\MovieFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //Categories's array to generate categories
        $categories = ['Action', 'Aventure', 'Humour', 'Horreur', 'Animé', 'Fantastique'];
        
        foreach (range(1, 6) as $i) {
            $category = new Category();
            $category->setName($categories[$i - 1]);
            $manager->persist($category);
            $this->addReference('category_' . $i, $category);   
        }

        $manager->flush();
    }
    
}