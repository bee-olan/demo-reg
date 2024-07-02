<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Uchasties;

use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;

class PersonaFetcher
{
    private $connection;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Persona::class);
    }

    public function find(string $id): ?Persona
    {
        return $this->repository->find($id);
    }

    public function assoc(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'nomer'               
            )
            ->from('adminka_uchasties_personas')
            ->orderBy('nomer')
            ->execute();

            return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function exists(string $id): bool
    {
        return $this->connection->createQueryBuilder()
                ->select('COUNT (id)')
                ->from('adminka_uchasties_personas')
                ->where('id = :id')
                ->setParameter(':id', $id)
                ->execute()->fetchColumn() > 0;
    }
	
	   public function allPers(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.nomer'
                // ,
                // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('adminka_uchasties_personas', 'p')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'g.id',
                'g.nomer'
                // ,
                // '(SELECT COUNT(*) FROM sait_u4astniks_u4astniks m WHERE m.godd_id = g.id) AS u4astniks'
            )
            ->from('adminka_uchasties_personas', 'g')
            ->orderBy('nomer')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}
