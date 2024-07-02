<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\Actions;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;

class ActionFetcher
{
    private $connection;
    private $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function all(Filter $filter, int $page, int $size): PaginationInterface
    {
        $qb = $this->createQb();

        if ($filter->uchastie) {
            $qb->innerJoin('plemmatka', 'adminka_matkas_plemmatka_uchastniks', 'uchastnik', 'plemmatka.id = uchastnik.plemmatka_id');
            $qb->andWhere('uchastnik.uchastie_id = :uchastie');
            $qb->setParameter(':uchastie', $filter->uchastie);
        }

        if ($filter->plemmatka) {
            $qb->andWhere('plemmatka.id = :plemmatka_id OR set_plemmatka.id = :plemmatka_id');
            $qb->setParameter(':plemmatka_id', $filter->plemmatka);
        }

        $qb->orderBy('c.date', 'desc');

        return $this->paginator->paginate($qb, $page, $size);
    }

    public function allForChildMatka(int $id): array
    {
        $stmt = $this->createQb()
            ->andWhere('childmatka.id = :childmatka_id')
            ->setParameter(':childmatka_id', (string)$id)
            ->orderBy('c.date', 'asc')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    private function createQb(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select(
                'c.*',
                'childmatka.name AS childmatka_name',
                'TRIM(CONCAT(actor.name_first, \' \', actor.name_last)) AS actor_name',
                'actor.nike AS actor_nike',
                'plemmatka.id AS plemmatka_id',
                'plemmatka.name AS plemmatka_name',
                'TRIM(CONCAT(set_executor.name_first, \' \', set_executor.name_last)) AS set_executor_name',
                'set_executor.nike AS set_executor_nike',
                'TRIM(CONCAT(set_revoked_executor.name_first, \' \', set_revoked_executor.name_last)) AS set_revoked_executor_name',
                'set_revoked_executor.nike AS set_revoked_executor_nike',
                'set_plemmatka.name AS set_plemmatka_name'
            )
            ->from('admin_matkas_child_changes', 'c')
            ->leftJoin('c', 'admin_uchasties_uchasties', 'actor', 'c.actor_id = actor.id')
            ->leftJoin('c', 'admin_uchasties_uchasties', 'set_executor', 'c.set_executor_id = set_executor.id')
            ->leftJoin('c', 'admin_uchasties_uchasties', 'set_revoked_executor', 'c.set_revoked_executor_id = set_executor.id')
            ->leftJoin('c', 'admin_matkas_childmatkas', 'childmatka', 'c.childmatka_id = childmatka.id')
            ->leftJoin('childmatka', 'admin_matkas_plemmatkas', 'plemmatka', 'childmatka.plemmatka_id = plemmatka.id')
            ->leftJoin('c', 'admin_matkas_plemmatkas', 'set_plemmatka', 'c.set_plemmatka_id = set_plemmatka.id');
    }



}
