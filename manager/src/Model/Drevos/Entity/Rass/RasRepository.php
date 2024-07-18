<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class RasRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Ras::class);
        $this->em = $em;
    }

    public function get(Id $id): Ras
    {
        /** @var Ras $rasa */
        if (!$rasa = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Ras is not found.');
        }
        return $rasa;
    }

    public function add(Ras $rasa): void
    {
        $this->em->persist($rasa);
    }

    public function remove(Ras $rasa): void
    {
        $this->em->remove($rasa);
    }
}
