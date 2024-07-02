<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\InfaMesto;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class MestoNomerRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(MestoNomer::class);
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

    public function get(Id $id): MestoNomer
    {
        /** @var MestoNomer $mestonomer */
        if (!$mestonomer = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('MestoNome is not found.');
        }
        return $mestonomer;
    }

    public function add(MestoNomer $mestonomer): void
    {
        //dd($mestonomer);
        $this->em->persist($mestonomer);
    }

    public function remove(MestoNomer $mestonomer): void
    {
        $this->em->remove($mestonomer);
    }
}
