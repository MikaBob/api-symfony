<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tags = [];
        for($i = 0; $i < 10; $i++) {
            $tags[$i] = new Tag();
            $tags[$i]->setName("Tag $i");
            $manager->persist($tags[$i]);
        }


        $manager->flush();


        $articles = [];
        for($i = 0; $i < 10; $i++) {
            $articles[$i] = new Article();
            $articles[$i]->setContent("Content of article $i");
            $articles[$i]->setTitle("Article #$i");
            $articles[$i]->setDatePublished(new \DateTime());
            $manager->persist($articles[$i]);
        }

        $articles[0]->addTag($tags[0]);
        $articles[0]->addTag($tags[1]);
        $articles[0]->addTag($tags[2]);

        $articles[1]->addTag($tags[0]);
        $articles[1]->addTag($tags[1]);
        $articles[1]->addTag($tags[4]);

        $articles[2]->addTag($tags[0]);
        $articles[2]->addTag($tags[3]);

        $manager->persist($articles[0]);
        $manager->persist($articles[1]);
        $manager->persist($articles[2]);


        $manager->flush();
    }
}
