<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\PcheloMatkas;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class PchelosezonFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Pchelosezon::class);
        $this->paginator = $paginator;
    }

    public function getPchelosezonId(string $pchelomatka, string $godaVixod): string
    {
        /**  Pchelosezon $pchelosezon  */
        if (!$pchelosezon = $this->repository->findOneBy([
            'pchelomatka' => $pchelomatka,
            'name' => $godaVixod
        ]))
        {
            throw new EntityNotFoundException('Нет такого сезона.');
        }
        return $pchelosezon->getId()->getValue();
    }

    public function has(string $pchelomatka): bool
    {
        return $this->repository->createQueryBuilder('t')
                ->select('COUNT(t.pchelomatka)')
                ->andWhere('t.pchelomatka = :pchelomatka')
                ->setParameter(':pchelomatka', $pchelomatka)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getMaxPchelo(string $pchelomatka): int
    {
        return (int)$this->connection->createQueryBuilder()
            ->select('MAX(s.name) AS m')
            ->from('admin_pchelomat_pchelosezons', 's')
            ->andWhere('pchelomatka_id = :pchelomatkas')
            ->setParameter(':pchelomatkas', $pchelomatka)
            ->execute()->fetch()['m'];
    }

    public function allPcheloSezon(string $pchelomatka, string $sezon): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.pchelomatka_id',
                'd.name'
            )
            ->from('admin_pchelomat_pchelosezons', 'd')
            ->andWhere('d.pchelomatka_id = :pchelomatka AND d.name = :sezon')
            ->setParameter(':pchelomatka', $pchelomatka)
            ->setParameter(':sezon', $sezon)
            ->orderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }


    public function listOfPcheloMatka(string $pchelomatka): array
    {

        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('admin_pchelomat_pchelosezons')
            ->andWhere('pchelomatka_id = :pchelomatka')
            ->setParameter(':pchelomatka', $pchelomatka)
            ->orderBy('name')
            ->execute();
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

// посчитать вручнкю всех участников этого проекта
    public function allOfPcheloMatka(string $pchelomatka): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'd.id',
                'd.name',
                '(
                    SELECT COUNT(ms.uchastie_id)
                    FROM admin_pchelomat_pchelovods ms
                    INNER JOIN admin_pchelomat_pchelovod_pchelosezons md ON ms.id = md.pchelovod_id
                    WHERE md.pchelosezon_id = d.id AND ms.pchelomatka_id = :pchelomatka
                ) AS uchasties_count'
            )
            ->from('admin_pchelomat_pchelosezons', 'd')
            ->andWhere('pchelomatka_id = :pchelomatka')
            ->setParameter(':pchelomatka', $pchelomatka)
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function allOfUchastie(string $uchastie): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'p.id AS pchelomatka_id',
                'p.name AS pchelomatka_name',
                'd.id AS pchelosezon_id',
                'd.name AS pchelosezon_name'
            )
            ->from('adminka_pchelomat_pchelovods', 'ms')
            ->innerJoin('ms', 'admin_pchelomat_pchelovod_pchelosezons', 'msd', 'ms.id = msd.pchelovod_id')
            ->innerJoin('msd', 'admin_pchelomat_pchelosezons', 'd', 'msd.pchelosezon_id = d.id')
            ->innerJoin('d', 'admin_pchelomats', 'p', 'd.pchelomatka_id = p.id')
            ->andWhere('ms.uchastie_id = :uchastie')
            ->setParameter(':uchastie', $uchastie)
            ->orderBy('p.sort')->addOrderBy('d.name')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
//
//    public function allOfUchastnik(string $uchastie): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'p.id AS pchelomatka_id',
//                'p.name AS pchelomatka_name',
//                'd.id AS pchelosezon_id',
//                'd.name AS pchelosezon_name'
//            )
//         //   ->from('admin_matkas_pchelomatka_pchelovods', 'ms')
////            ->innerJoin('ms', 'admin_matkas_pchelomatka_pchelovod_pchelosezons', 'msd', 'ms.id = msd.pchelovod_id')
//            ->innerJoin('msd', 'admin_matkas_pchelomatka_pchelosezons', 'd', 'msd.pchelosezon_id = d.id')
//            ->innerJoin('d', 'admin_matkas_pchelomatkas', 'p', 'd.pchelomatka_id = p.id')
//            ->andWhere('ms.uchastie_id = :uchastie')
//            ->setParameter(':uchastie', $uchastie)
//            ->orderBy('p.sort')->addOrderBy('d.name')
//            ->execute();
//
//        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
//    }
}
