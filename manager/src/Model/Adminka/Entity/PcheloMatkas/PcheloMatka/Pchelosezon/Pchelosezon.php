<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_pchelomat_pchelosezons")
 */
class Pchelosezon
{
    /**
     * @var PcheloMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka", inversedBy="pchelosezons")
     * @ORM\JoinColumn(name="pchelomatka_id", referencedColumnName="id", nullable=false)
     */
    private $pchelomatka;

    /**
     * @var Id
     * @ORM\Column(type="admin_pchelomat_pchelosezon_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(PcheloMatka $pchelomatka, Id $id, string $name)
    {
        $this->pchelomatka = $pchelomatka;
        $this->id = $id;
        $this->name = $name;
    }

    public function edit(string $name): void
    {
        $this->name = $name;

    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPchelomatka(): PcheloMatka
    {
        return $this->pchelomatka;
    }
}
