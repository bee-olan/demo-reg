<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\InfaMesto;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mesto_mestonomers")
 */
class MestoNomer
{
    /**
     * @var Id
     * @ORM\Column(type="mesto_mestonomer_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="raion_id")
     */
    private $raionId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomer;


    public function __construct(Id $id, string $raionId, string $nomer)
    {
        $this->id = $id;
        $this->raionId = $raionId;
        $this->nomer = $nomer;
    }

    public function edit(string $nomer): void
    {
        $this->nomer = $nomer;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getRaionId(): string
    {
        return $this->raionId;
    }

    public function getNomer(): string
    {
        return $this->nomer;
    }


}
