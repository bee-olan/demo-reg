<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs\Oblasts\Raions;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class RaionRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Raion::class);
        $this->em = $em;
    }

    public function get(Id $id): Raion
    {
        /** @var Raion $raion */
        if (!$raion = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Raions is not found.');
        }
        return $raion;
    }

    public function add(Raion $raion): void
    {
        $this->em->persist($raion);
    }

    public function remove(Raion $raion): void
    {
        $this->em->remove($raion);
    }
}