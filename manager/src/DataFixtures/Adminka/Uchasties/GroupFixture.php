<?php


namespace App\DataFixtures\Adminka\Uchasties;

use App\Model\Adminka\Entity\Uchasties\Group\Group;
use App\Model\Adminka\Entity\Uchasties\Group\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class GroupFixture extends Fixture
{
    public const REFERENCE_MATKOW= 'paseka_uchastie_group_makow';
    public const REFERENCE_PCHEL= 'paseka_uchastie_group_pchel';
    public const REFERENCE_PCHELMATKOW= 'paseka_uchastie_group_pchelmakow';
    public const REFERENCE_NADLUD = 'paseka_uchastie_group_nablud';

    public function load(ObjectManager $manager): void
    {
        $makow = new Group(
            Id::next(),
            'Матководы'
        );
        $manager->persist($makow);
        $this->setReference(self::REFERENCE_MATKOW, $makow);

        $pchel = new Group(
            Id::next(),
            'Пчеловоды'
        );
        $manager->persist($pchel);
        $this->setReference(self::REFERENCE_PCHEL, $pchel);

        $pchelmakow = new Group(
            Id::next(),
            'Пчело-Матководы'
        );
        $manager->persist($pchelmakow);
        $this->setReference(self::REFERENCE_PCHELMATKOW, $pchelmakow);

        $nablud = new Group(
            Id::next(),
            'Наблюдатели'
        );
        $manager->persist($nablud);
        $this->setReference(self::REFERENCE_NADLUD, $nablud);

    $manager->flush();
    }

}