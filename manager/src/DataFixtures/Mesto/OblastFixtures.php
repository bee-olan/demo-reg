<?php


namespace App\DataFixtures\Mesto;



use App\DataFixtures\Mesto\OkrugFixtures;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Id;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Okrug;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class OblastFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_ROST= 'mesto_obl_rost';
    public const REFERENCE_PERM= 'mesto_obl_perm';
    public const REFERENCE_JAROS= 'mesto_obl_jaros';


    public function load(ObjectManager $manager): void
    {

        /**
         * @var Oblast $name
         * @var Oblast $nomer
         * @var Oblast $mesto
         */

        /**
         * @var Okrug $ugg
         * @var Okrug $priwol
         * @var Okrug $centr
         */
        $ugg = $this->getReference(OkrugFixtures::REFERENCE_UGG);
        $priwol = $this->getReference(OkrugFixtures::REFERENCE_PRIWOL);
        $centr = $this->getReference(OkrugFixtures::REFERENCE_CENTR);
//

        $jaros = $this->createOblast($centr, $name="Ярославская обл", $nomer= "76", $mesto = "1-76");
        $manager ->persist($jaros);
        $this->setReference(self::REFERENCE_JAROS, $jaros);

        $rost = $this->createOblast($ugg, $name="Ростовская обл", $nomer = "61", $mesto = "3-61");
        $manager->persist($rost);
        $this->setReference(self::REFERENCE_ROST, $rost);

        $perm = $this->createOblast($priwol, $name="Пермский край ", $nomer = "59", $mesto= "5-59");
        $manager->persist($perm);
        $this->setReference(self::REFERENCE_PERM, $perm);

        $bash = $this->createOblast($priwol, $name="Рес-ка Башкортостан", $nomer = "02", $mesto= "5-02");
        $manager->persist($bash);
        $this->setReference(self::REFERENCE_PERM, $bash);

//        $oblast = $this->createOblast(2, $name="Ленинградская область ", $nomer = "47", $mesto= "2-47");
//        $manager->persist($oblast);

//        $oblast = $this->createOblast(2, $name="Вологодская область 	 ", $nomer = "35", $mesto= "2-35");
//        $manager->persist($oblast);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
//            UserFixture::class,
            OkrugFixtures::class,
        ];
    }

    private function createOblast( Okrug $okrug, string $name, string $nomer, string $mesto): Oblast
    {

        return new Oblast(
            $okrug,
            Id::next(),
            $name,
            $nomer,
            $mesto
        );
    }
}