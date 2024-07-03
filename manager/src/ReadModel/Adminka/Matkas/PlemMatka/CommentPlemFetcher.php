<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\PlemMatka;


//use App\Model\Adminka\Entity\Matkas\PlemMatka\ChildMatka;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\ReadModel\Comment\CommentRow;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class CommentPlemFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function allForPlemMatka(string $id): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'c.id',
                'c.date',
                'm.id AS author_id',
                'TRIM(CONCAT(m.name_first, \' \', m.name_last)) AS author_name',
                'm.email AS author_email',
                'm.nike as author_nike',
                'c.text'
            )
            ->from('comment_comments', 'c')

            ->innerJoin('c', 'admin_uchasties_uchasties', 'm', 'c.author_id = m.id')
            ->andWhere('c.entity_type = :entity_type AND c.entity_id = :entity_id')
            ->setParameter(':entity_type', PlemMatka::class)
            ->setParameter(':entity_id', $id)
            ->orderBy('c.date')
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, CommentRow::class);

        return $stmt->fetchAll();
    }
}