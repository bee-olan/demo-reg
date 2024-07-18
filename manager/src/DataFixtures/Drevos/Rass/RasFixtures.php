<?php

declare(strict_types=1);

namespace App\DataFixtures\Drevos\Rass;

use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Drevos\Entity\Rass\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RasFixtures extends Fixture
{
    public const REFERENCE_SREDRUSS= 'ras_sredruss';
    public const REFERENCE_KARNIK= 'ras_karnik';
    public const REFERENCE_JAK_KARNIK= 'ras_jak_karnik';
    public const REFERENCE_ITALL= 'ras_itall';

    public function load(ObjectManager $manager): void
    {

        $nets = new Ras(
            Id::next(),
            ' -- нет нужной',
            '...'
        );
        $manager->persist($nets);
//        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);


        $sredruss = new Ras(
            Id::next(),
            'Ср',
            'Среднерусская'
        );
        $manager->persist($sredruss);
        $this->setReference(self::REFERENCE_SREDRUSS, $sredruss);
//---------------
        $karnik = new Ras(
            Id::next(),
            'Кр',
            'Карника'
        );
        $manager->persist($karnik);
        $this->setReference(self::REFERENCE_KARNIK, $karnik);

//---------------
        $jak = new Ras(
            Id::next(),
            'Як',
            'Ярославская карника'
        );
        $manager->persist($jak);
        $this->setReference(self::REFERENCE_JAK_KARNIK, $jak);

//---------------
        $itall = new Ras(
            Id::next(),
            'Ит',
            'Итальянка'
        );
        $manager->persist($itall);
        $this->setReference(self::REFERENCE_ITALL, $itall);

    $manager->flush();
    }

}