<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\PcheloMatkas;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class KategoriaFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

//    public function assoc(): array
//    {
//        $stmt = $this->connection->createQueryBuilder()
//            ->select(
//                'id',
//                'name'
//            )
//            ->from('admin_pchel_sparings')
//           // ->orderBy('nomer')
//            ->execute();
//
//        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
//    }

    public function allList(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name'
            )
            ->from('admin_pchel_kategorias')
            ->orderBy('name')
            ->execute();

        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'r.id',
                'r.name',
                'r.permissions'
//                ,
//                '(SELECT COUNT(*) FROM admin_matkas_plemmatka_uchastnik_kategorias m WHERE m.kategoria_id = r.id) AS uchastniks_count'
            )
            ->from('admin_pchel_kategorias', 'r')
            ->orderBy('name')
            ->execute();

        return array_map(static function (array $kategoria) {
            return array_replace($kategoria, [
                'permissions' => json_decode($kategoria['permissions'], true)
            ]);
        }, $stmt->fetchAll(FetchMode::ASSOCIATIVE));
    }
}

