<?php

declare(strict_types=1);

namespace App\ReadModel\Mesto\Oblasts\Raions;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class RaionFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    

    public function listOfOblast(string $oblast): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'nomer',
                'mesto'
            )
            ->from('mesto_okrug_oblast_raions')
            ->andWhere('oblast_id = :oblast')
            ->setParameter(':oblast', $oblast)
            ->orderBy('nomer')
            ->orderBy('mesto')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function allOfOblast(string $oblast): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                'd.nomer',
                'd.mesto'
                // '(
                //     SELECT COUNT(ms.member_id)
                //     FROM work_projects_project_memberships ms
                //     INNER JOIN work_projects_project_membership_departments md ON ms.id = md.membership_id
                //     WHERE md.department_id = d.id AND ms.materi_id = :okrug
                // ) AS members_count'
            )
            ->from('mesto_okrug_oblast_raions', 'd')
            ->andWhere('oblast_id = :oblast')
            ->setParameter(':oblast', $oblast)
            ->orderBy('nomer')
            ->orderBy('mesto')
            ->execute();

            return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        }
}
