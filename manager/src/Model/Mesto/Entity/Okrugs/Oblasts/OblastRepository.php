<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs\Oblasts;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class OblastRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Oblast::class);
        $this->em = $em;
    }

    public function get(Id $id): Oblast
    {
        /** @var Oblast $oblast */
        if (!$oblast = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Oblasts is not found.');
        }
        return $oblast;
    }

    public function add(Oblast $oblast): void
    {
        $this->em->persist($oblast);
    }

    public function remove(Oblast $oblast): void
    {
        $this->em->remove($oblast);
    }
}
