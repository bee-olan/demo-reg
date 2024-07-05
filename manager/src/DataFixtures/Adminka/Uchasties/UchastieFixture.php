<?php

declare(strict_types=1);

namespace App\DataFixtures\Adminka\Uchasties;

use App\DataFixtures\UserFixture;
use App\Model\Adminka\Entity\Uchasties\Group\Group;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Email;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Name;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\User\Entity\User\User;

//use App\Model\Work\Entity\Members\Group\Group;
//use App\Model\Work\Entity\Members\Member\Email;
//use App\Model\Work\Entity\Members\Member\Member;
//use App\Model\Work\Entity\Members\Member\Id;
//use App\Model\Work\Entity\Members\Member\Name;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UchastieFixture extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_ADMIN = 'uchastie_admin';
    public const REFERENCE_USER = 'uchastie_user';

    public function load(ObjectManager $manager): void
    {
        /**
         * @var User $admin
         * @var User $user
         */
        $admin = $this->getReference(UserFixture::REFERENCE_ADMIN);
        $user = $this->getReference(UserFixture::REFERENCE_USER);

        /**
         * @var Group $makow
         * @var Group $pchel
         * @var Group $pchelmakow
         * @var Group $nablud
         */
        $makow = $this->getReference(GroupFixture::REFERENCE_MATKOW);
        $pchel = $this->getReference(GroupFixture::REFERENCE_PCHEL);
        $pchelmakow = $this->getReference(GroupFixture::REFERENCE_PCHELMATKOW);
        $nablud = $this->getReference(GroupFixture::REFERENCE_NADLUD);

        $uchastie = $this->createUchastie($admin, $makow, $nike= 'OlAn');
        $manager->persist($uchastie);
        $this->setReference(self::REFERENCE_ADMIN, $uchastie);

        $uchastie = $this->createUchastie($user, $nablud, $nike= 'Пчеловод');
        $manager->persist($uchastie);
        $this->setReference(self::REFERENCE_USER, $uchastie);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            GroupFixture::class,
        ];
    }

    private function createUchastie(User $user, Group $group,string $nike): Uchastie
    {
        return new Uchastie(
            new Id($user->getId()->getValue()),
            new \DateTimeImmutable(),
            $group,
            new Name(
                $user->getName()->getFirst(),
                $user->getName()->getLast()
            ),
            new Email($user->getEmail() ? $user->getEmail()->getValue() : null),
            $nike
        );
    }
}
