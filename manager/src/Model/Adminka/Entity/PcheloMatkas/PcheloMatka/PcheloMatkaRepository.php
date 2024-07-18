<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Id AS KategoriaId;
use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PcheloMatkaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(PcheloMatka::class);
        $this->em = $em;
    }

    public function hasPchelMatkaWithKategor(KategoriaId $id): bool
    {
        return $this->repo->createQueryBuilder('p')
                ->select('COUNT(p.id)')
//                ->innerJoin('p.pchelomatka', 'ms')
                ->innerJoin('p.kategoria', 'r')
                ->andWhere('r.id = :kategoria')
                ->setParameter(':kategoria', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): PcheloMatka
    {
        /** @var PcheloMatka $pchelomatka */
        if (!$pchelomatka = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('PcheloMatka is not found.');
        }
        return $pchelomatka;
    }

    public function getPlemId(string $name): Id
    {
        /** @var PcheloMatka $pchelomatka */
        if (!$pchelomatka = $this->repo->findOneBy(['name' => $name])) {
            throw new EntityNotFoundException('Нет такой ПлемМатки.');
        }
        return $pchelomatka->getId();
    }

//    public function getPlemSezon(Id $id, string $sezon): PcheloMatka
//    {
//        /** @var PcheloMatka $pchelomatka */
//        if (!$pchelomatka = $this->repo->find($id->getValue())) {
//            throw new EntityNotFoundException('PcheloMatka is not found.');
//        }
//        return $pchelomatka;
//    }

    public function hasByName(string $title): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.title)')
                ->andWhere('t.title = :title')
                ->setParameter(':title', $title)
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function hasBySort(int $sort): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.sort = :sort')
                ->setParameter(':sort', $sort)
                ->getQuery()->getSingleScalarResult() > 0;
    }


    public function add(PcheloMatka $pchelomatka): void
    {
        $this->em->persist($pchelomatka);
    }

    public function remove(PcheloMatka $pchelomatka): void
    {
        $this->em->remove($pchelomatka);
    }
}
