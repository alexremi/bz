<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // create admin user
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@localhost');
        $admin->setPassword(
            $this->encoder->encodePassword($admin, '7889')
        );

        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        // create user
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@localhost');
        $user->setPassword(
            $this->encoder->encodePassword($user, '1234')
        );

        $manager->persist($user);

        $manager->flush();
    }
}