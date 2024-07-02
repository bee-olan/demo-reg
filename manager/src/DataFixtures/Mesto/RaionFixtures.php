<?php

declare(strict_types=1);

namespace App\DataFixtures\Mesto;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Id;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RaionFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        /**
         * @var Raion $name
         * @var Raion $nomer
         * @var Raion $mesto
         */

        /**
         * @var Oblast $rost
         * @var Oblast $perm
         * @var Oblast $jaros
         * @var Oblast $bash
         */
        $rost = $this->getReference(OblastFixtures::REFERENCE_ROST);
        $perm = $this->getReference(OblastFixtures::REFERENCE_PERM);
        $jaros =$this->getReference(OblastFixtures::REFERENCE_JAROS);
        $bash   =$this->getReference(OblastFixtures::REFERENCE_PERM);


        $rai = $this->createRaion($jaros, $name= "Ростовский район ", $nomer="12", $mesto= "1-76-12");
        $manager->persist($rai);

        $rai = $this->createRaion($rost, $name="Азовский район", $nomer = "1", $mesto = "3-61-1");
        $manager->persist($rai);

        $rai = $this->createRaion($rost, $name="Аксайский район", $nomer = "2", $mesto = "3-61-2");
        $manager->persist($rai);

        $rai = $this->createRaion($rost, $name="Багаевский район", $nomer = "3", $mesto = "3-61-3");
        $manager->persist($rai);
   /////////////////////////////////
        $rai = $this->createRaion($perm, $name="Гайнский район", $nomer = "1", $mesto = "5-59-1");
        $manager->persist($rai);

         $rai = $this->createRaion($bash, $name="Уфимский район", $nomer = "47", $mesto = "5-02-47");
         $manager->persist($rai);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OblastFixtures::class,
        ];
    }

    private function createRaion( Oblast $oblast, string $name, string $nomer, string $mesto): Raion
    {

        return new Raion(
            $oblast,
            Id::next(),
            $name,
            $nomer,
            $mesto
        );
    }
}