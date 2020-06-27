<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CreateAdminCommand.
 */
class CreateAdminCommand extends Command
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface       $manager
     * @param string|null                  $name
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, string $name = null)
    {
        parent::__construct($name);

        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Create default admin')
            ->setName('admin')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@localhost');
        $admin->setPassword(
            $this->encoder->encodePassword($admin, 'admin')
        );

        $admin->setRoles(['ROLE_ADMIN']);

        $this->manager->persist($admin);
        $this->manager->flush();

        return null;
    }
}
