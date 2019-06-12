<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    private $ROLES = [
        'ROLE_ADMIN','ROLE_USER'
        ];
    protected function loadData(ObjectManager $manager)
    {
        /*$this->createMany(User::class,10, 'main_users', function ($i){
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            return $user;
        });*/
        $this->createMany(User::class,10, function (User $user,$count) use ($manager){
            $user->setEmail($this->faker->email);
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $user->setTwitterUsername($this->faker->userName);
            $user->setRoles($this->faker->randomElements($this->ROLES));
            return $user;
        }
        );
        $manager->flush();
    }
}
