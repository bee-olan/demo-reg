<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs;


use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class OkrugRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Okrug::class);
        $this->em = $em;
    }

    public function has(Id $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasName(string $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.name)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasNomer(string $nomer): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.nomer)')
                ->andWhere('t.nomer = :nomer')
                ->setParameter(':nomer', $nomer)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): Okrug
    {
        /** @var Okrug $okrug */
        if (!$okrug = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Okrug is not found.');
        }
        return $okrug;
    }

    public function add(Okrug $okrug): void
    {
        $this->em->persist($okrug);
    }

    public function remove(Okrug $okrug): void
    {
        $this->em->remove($okrug);
    }
}
