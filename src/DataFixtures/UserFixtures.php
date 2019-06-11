<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends AppFixtures
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class,10,function(User $user,$count) use ($manager){
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            return $user;
        });
        $manager->flush();
    }
}
