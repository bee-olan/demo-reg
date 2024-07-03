<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Uchasties\Uchastie;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;
use App\ReadModel\Adminka\Uchasties\Uchastie\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class UchastieFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Uchastie::class);
        $this->paginator = $paginator;
    }

    public function find(string $id): ?Uchastie
    {
        return $this->find($id);
//        return $this->repository->find($id);
    }


    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'TRIM(CONCAT(name_first, \' \', name_last, \'  - \', nike)) AS name'
            )
            ->from('admin_uchasties_uchasties')
            ->orderBy('nike')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
    /**
     * @param Filter $filter
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function allProekt(Filter $filter, int $page, int $size, string $sort, string $direction): PaginationInterface
    {

        $qb = $this->connection->createQueryBuilder()
            ->select(
                'm.id',
//                'TRIM(CONCAT( m.name_nike)) AS name',
                'm.email',
                'm.nike',
                'g.name as group',
                'm.status',
                'n.nomer AS mesto',
                'p.nomer AS persona'
//                '(SELECT COUNT(*) FROM admin_matkas_plemmatka_uchastnik_departments d WHERE  d.uchastnik_id = m.id) as sezon_count',
//                '(SELECT COUNT(*) FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.uchastie_id = m.id) as uchastniks_count')
//                '(SELECT COUNT(*) FROM admin_sezons_uchasgodas ug WHERE  ug.uchastie_id = m.id) as uchasgodas_count')
//                '(SELECT COUNT(*) FROM paseka_sezons_uchasgodas ug WHERE ug.uchastie_id = m.id) as uchasgodas_count'            )
            )
            ->from('admin_uchasties_uchasties', 'm')
            ->innerJoin('m', 'admin_uchasties_groups', 'g', 'm.group_id = g.id')
            ->innerJoin('m', 'mesto_mestonomers', 'n', 'm.id = n.id')
            ->innerJoin('m', 'adminka_uchasties_personas', 'p', 'm.id = p.id');

        if ($filter->nike) {
            $qb->andWhere($qb->expr()->like('LOWER( m.nike))', ':nike'));
            $qb->setParameter(':nike', '%' . mb_strtolower($filter->nike) . '%');
        }


        if ($filter->status) {
            $qb->andWhere('m.status = :status');
            $qb->setParameter(':status', $filter->status);
        }

        if ($filter->group) {
            $qb->andWhere('m.group_id = :group');
            $qb->setParameter(':group', $filter->group);
        }


        if (!\in_array($sort, ['nike', 'email', 'group', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }
        $qb->orderBy('"' . $sort . '"', $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
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
                'm.id',
//                'TRIM(CONCAT(m.name_first, \' \', m.name_last, \' \', m.name_nike)) AS name',
                'm.email',
                'm.nike',
                'g.name as group',
                'm.status'
//                'ug.uchastie_id AS uchgod',
//                '(SELECT COUNT(*) FROM adminka_matkas_plemmatka_uchastniks ms WHERE ms.uchastie_id = m.id) as uchastniks_count',
//                '(SELECT COUNT(*) FROM admin_sezons_uchasgodas ug WHERE  uchgod = m.id) as uchasgodas_count'
            )
            ->from('admin_uchasties_uchasties', 'm')
            ->innerJoin('m', 'admin_uchasties_groups', 'g', 'm.group_id = g.id');
           // ->innerJoin('m', 'admin_uchasties_personas', 'p', 'm.id = p.id');

        if ($filter->nike) {
            $qb->andWhere($qb->expr()->like('LOWER( m.nike))', ':nike'));
            $qb->setParameter(':nike', '%' . mb_strtolower($filter->nike) . '%');
        }

        if ($filter->email) {
            $qb->andWhere($qb->expr()->like('LOWER(m.email)', ':email'));
            $qb->setParameter(':email', '%' . mb_strtolower($filter->email) . '%');
        }

         if ($filter->status) {
             $qb->andWhere('m.status = :status');
             $qb->setParameter(':status', $filter->status);
         }

        if ($filter->group) {
            $qb->andWhere('m.group_id = :group');
            $qb->setParameter(':group', $filter->group);
        }


        if (!\in_array($sort, ['nike', 'email', 'group', 'status'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }
        $qb->orderBy('"' . $sort . '"', $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('admin_uchasties_uchasties')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }


    
    public function activeGroupedList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'm.nike',
                'CONCAT(m.name_first, \' \', m.name_last) AS name',
                'g.name AS group',
                'p.nomer AS persona'
            ])
            ->from('admin_uchasties_uchasties', 'm')
            ->leftJoin('m', 'adminka_uchasties_personas', 'p', 'p.id = m.id')
            ->leftJoin('m', 'admin_uchasties_groups', 'g', 'g.id = m.group_id')
             ->andWhere('m.status = :status')
             ->setParameter(':status', Status::ACTIVE)
            ->orderBy('g.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function activePeriodListForElitMatka(int $elitmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'CONCAT(m.name_first, \' \', m.name_last) AS name'
                //,
                //'d.name AS department'
            ])
            ->from('admin_uchasties_uchasties', 'm')
            ->innerJoin('m', 'admin_elitmat_sostavs', 'ms', 'ms.member_id = m.id')
            ->innerJoin('ms', 'admin_elitmat_sostav_periods', 'msd', 'msd.sostav_id = ms.id')
            ->innerJoin('msd', 'admin_elitmat_periods', 'd', 'd.id = msd.period_id')
            ->andWhere('m.status = :status AND ms.elitmatka_id = :elitmatka')
            ->setParameter(':status', Status::ACTIVE)
            ->setParameter(':elitmatka', $elitmatka)
             ->orderBy('d.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function activeDepartmentListForPlemMatka(string $plemmatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select([
                'm.id',
                'CONCAT(m.name_first, \' \', m.name_last) AS name'
                //,
                //'d.name AS department'
            ])
            ->from('admin_uchasties_uchasties', 'm')
//            ->innerJoin('m', 'work_projects_project_memberships', 'ms', 'ms.member_id = m.id')
//            ->innerJoin('ms', 'work_projects_project_membership_departments', 'msd', 'msd.membership_id = ms.id')
//            ->innerJoin('msd', 'work_projects_project_departments', 'd', 'd.id = msd.department_id')
//            ->andWhere('m.status = :status AND ms.project_id = :project')
//            ->setParameter(':status', Status::ACTIVE)
//            ->setParameter(':project', $project)
            // ->orderBy('d.name')->addOrderBy('name')
            ->execute();
        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }


}
