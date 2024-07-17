<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\PcheloMatkas\Kategoria;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class KategoriaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Kategoria::class);
        $this->em = $em;
    }

    public function hasByName(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.name)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }
//    public function hasByNomer(string $nomer): bool
//    {
//        return $this->repo->createQueryBuilder('t')
//                ->select('COUNT(t.nomer)')
//                ->andWhere('t.nomer = :nomer')
//                ->setParameter(':nomer', $nomer)
//                ->getQuery()->getSingleScalarResult() > 0;
 //   }

    public function get(Id $id): Kategoria
    {
        /** @var Kategoria $kategoria */
        if (!$kategoria = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('kategoria is not found.');
        }
        return $kategoria;
    }


    public function add(Kategoria $kategoria): void
    {
        $this->em->persist($kategoria);
    }

    public function remove(Kategoria $kategoria): void
    {
        $this->em->remove($kategoria);
    }
}