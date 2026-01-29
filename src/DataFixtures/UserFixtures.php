<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Create Admin User
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'lala88');
        $admin->setPassword($hashedPassword);
        
        $manager->persist($admin);
        $this->addReference('user_admin', $admin);

        // 2. Create Regular Users
        $usersData = [
            [
                'email' => 'claucode88@gmail.com',
                'password' => 'lala88',
            ],
            [
                'email' => 'jane@example.com',
                'password' => 'lala88',
            ],
            [
                'email' => 'alice@bilbostack.com',
                'password' => 'lala88',
            ],
            [
                'email' => 'bob@bilbostack.com',
                'password' => 'lala88',
            ],
            [
                'email' => 'bgallastegui86@gmail.com',
                'password' => 'lala88',
            ],
        ];

        foreach ($usersData as $index => $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setIsVerified(true);
            
            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
            $this->addReference('user_' . ($index + 1), $user);
        }

        $manager->flush();
    }
}