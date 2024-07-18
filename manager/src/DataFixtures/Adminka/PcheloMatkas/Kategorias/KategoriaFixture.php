<?php


namespace App\DataFixtures\Adminka\PcheloMatkas\Kategorias;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Kategoria;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Id;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Permission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class KategoriaFixture extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $bre = $this->createKategoria('бр', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_TRUT_90,
            Permission::KATEGORIA_F_1,
            Permission::KATEGORIA_SELEK_RABOT,
        ]);
        $manager->persist($bre);

        $bre_c = $this->createKategoria('бр/с', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_TRUT_SELEK,
            Permission::KATEGORIA_F_1,
            Permission::KATEGORIA_SELEK_RABOT,
        ]);
        $manager->persist($bre_c);

        $bre_a = $this->createKategoria('бр/а', [
            Permission::KATEGORIA_NET_DOKUM,
            Permission::KATEGORIA_TRUT_NET,
            Permission::KATEGORIA_F_2,
            Permission::KATEGORIA_SELEK_RABOT,
        ]);
        $manager->persist($bre_a);

        $net = $this->createKategoria('-', [
//            Permission::KATEGORIA_DOKUM,
//            Permission::KATEGORIA_F_0,
        ]);
        $manager->persist($net);

        $mes = $this->createKategoria('м', [
            Permission::KATEGORIA_DOKUM,
            Permission::KATEGORIA_TRUT_NET,
            Permission::KATEGORIA_F_0,
        ]);
        $manager->persist($mes);

        $mesc = $this->createKategoria('м/с', [
            Permission::KATEGORIA_TRUT_SELEK,
            Permission::KATEGORIA_DOKUM,
            Permission::KATEGORIA_F_0,
            Permission::KATEGORIA_TRUT_SELEK,
        ]);
        $manager->persist($mesc);

        $mesa = $this->createKategoria('м/а', [
            Permission::KATEGORIA_TRUT_NET,
            Permission::KATEGORIA_F_0,
            Permission::KATEGORIA_SELEK_RABOT,
        ]);
        $manager->persist($mesa);

        $manager->flush();
    }

    private function createKategoria(string $name, array $permissions): Kategoria
    {
        return new Kategoria(
            Id::next(),
            $name,
            $permissions
        );
    }

}