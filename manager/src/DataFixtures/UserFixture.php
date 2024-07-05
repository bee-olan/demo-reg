<?php

namespace App\DataFixtures;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Id;
use App\Model\User\Service\PasswordHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public const REFERENCE_ADMIN = 'user_user_admin';
    public const REFERENCE_USER = 'user_user_user';
    public const REFERENCE_MODERATOR = 'user_user_moderator';
    private $hasher;

    public function __construct(PasswordHasher $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $hash = $this->hasher->hash('password');

        $network = $this->createSignedUpByNetwork(
            new Name('David', 'Black'),
            'facebook',
            '1000000'
        );
        $manager->persist($network);

        $requested = $this->createSignUpRequestedByEmail(
            new Name('John', 'Doe'),
            new Email('requested@app.test'),
            $hash
        );
        $manager->persist($requested);

        $confirmed = $this->createSignUpConfirmedByEmail(
            new Name('Пчелов', 'Пчеловод'),
            new Email('user@app.test'),
            $hash
        );
        $manager->persist($confirmed);
        $this->setReference(self::REFERENCE_USER, $confirmed);
//--------------------
        $admin = $this->createAdminByEmail(
            new Name('Ольга', 'Игоревна'),
            new Email('admin@app.test'),
            $hash
        );
        $manager->persist($admin);
        $this->setReference(self::REFERENCE_ADMIN, $admin);
//        -----------------
        $matkowod = $this->createModeratorByEmail(
            new Name('Дмитрий', 'Евгеньевич'),
            new Email('itlar@app.test'),
            $hash
        );
        $manager->persist($matkowod);
        $this->setReference(self::REFERENCE_MODERATOR, $matkowod);


        $matkow = $this->createModeratorByEmail(
            new Name('Дмитрий', 'Дмитриев'),
            new Email('carnicamed@yandex.ru'),
            $hash
        );
        $manager->persist($matkow);
        $this->setReference(self::REFERENCE_MODERATOR, $matkow);

//        -----------------

        $manager->flush();
    }

    private function createAdminByEmail(Name $name, Email $email, string $hash): User
    {
        $user = $this->createSignUpConfirmedByEmail($name, $email, $hash);
        $user->changeRole(Role::admin());
        return $user;
    }

    private function createModeratorByEmail(Name $name, Email $email, string $hash): User
    {
        $user = $this->createSignUpConfirmedByEmail($name, $email, $hash);
        $user->changeRole(Role::moderator());
        return $user;
    }

    private function createSignUpConfirmedByEmail(Name $name, Email $email, string $hash): User
    {
        $user = $this->createSignUpRequestedByEmail($name, $email, $hash);
        $user->confirmSignUp();
        return $user;
    }

    private function createSignUpRequestedByEmail(Name $name, Email $email, string $hash): User
    {
        return User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            $name,
            $email,
            $hash,
            'token'
        );
    }

    private function createSignedUpByNetwork(Name $name, string $network, string $identity): User
    {
        return User::signUpByNetwork(
            Id::next(),
            new \DateTimeImmutable(),
            $name,
            $network,
            $identity
        );
    }
}
