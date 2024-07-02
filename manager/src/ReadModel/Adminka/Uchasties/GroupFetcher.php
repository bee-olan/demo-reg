<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Uchasties;

use App\Annotation\Guid;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class GroupFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'               
            )
            ->from('admin_uchasties_groups')
            ->orderBy('name')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.name',
                '(SELECT COUNT(*) FROM admin_uchasties_uchasties m WHERE m.group_id = g.id) AS uchasties'
            )
            ->from('admin_uchasties_groups', 'g')
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
