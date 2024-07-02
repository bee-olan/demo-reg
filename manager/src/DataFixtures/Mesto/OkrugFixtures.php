<?php

declare(strict_types=1);

namespace App\DataFixtures\Mesto;

//use App\Model\Paseka\Entity\Rasas\Rasa;
//use App\Model\Paseka\Entity\Rasas\Id;

use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\Model\Mesto\Entity\Okrugs\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class OkrugFixtures extends Fixture
{
    public const REFERENCE_PRIWOL= 'mesto_okrug_priwol';
    public const REFERENCE_UGG= 'mesto_okrug_$ugg';
    public const REFERENCE_CENTR= 'mesto_okrug_centr';

    public function load(ObjectManager $manager): void
    {


        $centr = new Okrug(
            Id::next(),
            'Центральный округ',
            '1'
        );
        $manager->persist($centr);
        $this->setReference(self::REFERENCE_CENTR, $centr);

        $okrug = new Okrug(
            Id::next(),
            'Северо-Западный',
            '2'
        );
        $manager->persist($okrug);

        $ugg = new Okrug(
            Id::next(),
            'Южный',
            '3'
        );
        $manager->persist($ugg);
        $this->setReference(self::REFERENCE_UGG, $ugg);

        $priwol = new Okrug(
            Id::next(),
            ' Северо-Кавказский',
            '4'
        );
        $manager->persist($priwol);
        //$this->setReference(self::REFERENCE_PRIWOL, $priwol);

        $priwol = new Okrug(
            Id::next(),
            'Приволжский',
            '5'
        );
        $manager->persist($priwol);
        $this->setReference(self::REFERENCE_PRIWOL, $priwol);


        $okrug = new Okrug(
            Id::next(),
            'Уральский',
            '6'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Сибирский',
            '7'
        );
        $manager->persist($okrug);



        $okrug = new Okrug(
            Id::next(),
            'Дальневосточный',
            '8'
        );
        $manager->persist($okrug);

        $okrug = new Okrug(
            Id::next(),
            'Крымский федеральный округ',
            '9'
        );
        $manager->persist($okrug);



    $manager->flush();
    }

}