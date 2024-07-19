<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\PcheloMatkas\PcheloMatka;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\Filter\Filter;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PcheloMatkaFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, 
                                PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(PcheloMatka::class);
    }

//    public function find(string $id): ?PcheloMatka
//    {
//        return $this->repository->find($id);
//    }


    public function getMaxSort(): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(p.sort) AS m')
            ->from('admin_pchelomats', 'p')

            ->execute()->fetch()['m'];
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function allPagin(Filter $filter, int $page, int $size, ?string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'em.id',
                'em.name',
//                'em.persona',
                'em.status'
//                'dm.sort',
//                'pe.nomer as persona'
//                '(SELECT COUNT(*) FROM admin_elitmat_periods s WHERE s.pchelomatka_id = em.id) AS periods_count'
            )
            ->from('admin_pchelomatka', 'em')
//            ->innerJoin('em', 'adminka_uchasties_personas', 'pe', 'em.persona_id = pe.id')

        ;
//        if ($filter->uchastie) {
//            $qb->andWhere('EXISTS (
//                SELECT ms.uchastie_id FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.plemmatka_id = p.id AND ms.uchastie_id = :uchastie
//            )');
//            $qb->setParameter(':uchastie', $filter->uchastie);
//        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('em.name', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

//        if ($filter->status) {
//            $qb->andWhere('em.status = :status');
//            $qb->setParameter(':status', $filter->status);
//        }

        if (!\in_array($sort, ['name', 'status',  'persona'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }


    public function existsPerson(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('adminka_uchasties_personas')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    public function existsMesto(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('mesto_mestonomers')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }

    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'p.id',
                'p.name',
                'p.title',
                'p.persona_id',
                'p.status',
                'p.sort',
                'p.kategoria_id',
                'p.goda_vixod ',
                'pe.nomer as persona',
//                'k.name AS kategoria',
                '(SELECT COUNT(*) FROM admin_pchelomat_pchelosezons d WHERE d.pchelomatka_id = p.id) AS pchsezon_count',
//                '(SELECT COUNT(*) FROM admin_pchelo_childs c WHERE c.pchelomatka_id = p.id) AS child_count'
            )
            ->from('admin_pchelomats', 'p')
            ->innerJoin('p', 'adminka_uchasties_personas', 'pe', 'p.persona_id = pe.id')
//            ->innerJoin('p', 'admin_matkas_kategorias', 'k', 'p.kategoria_id = k.id')
        ;

        if ($filter->uchastie) {
            $qb->andWhere('EXISTS (
                SELECT ms.uchastie_id FROM admin_pchelomat_pchelovods ms WHERE ms.pchelomatka_id = p.id AND ms.uchastie_id = :uchastie
            )');
            $qb->setParameter(':uchastie', $filter->uchastie);
        }


        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(p.name)', ':name'));
            $qb->setParameter(':name', '%' . mb_strtolower($filter->name) . '%');
        }

        if ($filter->status) {
            $qb->andWhere('p.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->kategoria) {
//            $qb->andWhere($qb->expr()->like('LOWER(p.kategoria)', ':kategoria'));
//            $qb->setParameter(':kategoria', '%' . mb_strtolower($filter->kategoria) . '%');
            $qb->andWhere('k.name = :name');
            $qb->setParameter(':name', $filter->kategoria);
        }

        if ($filter->persona) {
            $qb->andWhere('p.persona = :persona');
            $qb->setParameter(':persona', $filter->persona);
        }

        if ($filter->goda_vixod) {
            $qb->andWhere('p.goda_vixod = :goda_vixod');
            $qb->setParameter(':goda_vixod', $filter->goda_vixod);
        }

        if (!\in_array($sort, ['name','persona', 'kategoria', 'status', 'goda_vixod'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
