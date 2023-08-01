<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const DATA = [
        [
            'username' => 'ben',
            'password' => 'benpass123',
            'roles' => [LoginFormAuthenticator::ROLE_USER]
        ],
        [
            'username' => 'ed',
            'password' => 'edpass123',
            'roles'    => [LoginFormAuthenticator::ROLE_USER, LoginFormAuthenticator::ROLE_SUPER_ADMIN],
        ],
        [
            'username' => 'matt',
            'password' => 'mattpass123',
            'roles'    => [LoginFormAuthenticator::ROLE_USER, LoginFormAuthenticator::ROLE_ADMIN],
        ],
        [
            'username' => 'simon',
            'password' => 'mattpass123',
            'roles' => [LoginFormAuthenticator::ROLE_USER]
        ],
        [
            'username' => 'geoff',
            'password' => 'geoffpass123',
            'roles'    => [LoginFormAuthenticator::ROLE_USER, LoginFormAuthenticator::ROLE_ADMIN],
        ],
    ];

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $userData) {
            $user = $manager->getRepository(User::class)->findOneby(['username' => $userData['username']]);

            if (!$user instanceof User) {
                $user = new User();
                $user->setUsername($userData['username']);

                $manager->persist($user);
            }

            $user->setRoles($userData['roles']);

            $hashedPassword = $this->passwordHasher
                ->hashPassword(
                    $user,
                    $userData['password'],
                );

            $user->setPassword($hashedPassword);
        }

        $manager->flush();
    }
}
