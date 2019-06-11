<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends AppFixtures
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 20, function (Article $article, $count) use ($manager) {
                $article->setName($this->faker->name);
                $article->setSlug($this->faker->slug);
                $article->setContent($this->faker->text);
                return $article;
        });
        $manager->flush();
    }
}
