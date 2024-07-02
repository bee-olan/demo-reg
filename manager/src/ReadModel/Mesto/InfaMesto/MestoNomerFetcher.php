<?php

declare(strict_types=1);

namespace App\ReadModel\Mesto\InfaMesto;

use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class MestoNomerFetcher
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(MestoNomer::class);
    }

    public function find(string $id): ?MestoNomer
    {
        return $this->repository->find($id);
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'raion_id',
                'nomer'               
            )
            ->from('mesto_mestonomers')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('mesto_mestonomers')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }
	
	   public function allMestNom(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'm.raion_id',
                'm.nomer AS mestonomer'
            )
            ->from('mesto_mestonomers', 'm')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'm.id',
                'm.nomer AS mestonomer'

            )
            ->from('mesto_mestonomers', 'm')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
