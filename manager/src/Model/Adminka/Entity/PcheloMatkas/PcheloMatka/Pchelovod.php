<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Id AS PchelosezonId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_pchelomat_pchelovods", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"pchelomatka_id", "uchastie_id"})
 * })
 */
class Pchelovod
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var PcheloMatka
     * @ORM\ManyToOne(targetEntity="PcheloMatka", inversedBy="uchasniks")
     * @ORM\JoinColumn(name="pchelomatka_id", referencedColumnName="id", nullable=false)
     */
    private $pchelomatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;

    /**
     * @var ArrayCollection|Pchelosezon[]
     * @ORM\ManyToMany(targetEntity="App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon")
     * @ORM\JoinTable(name="admin_pchelomat_pchelovod_pchelosezons",
     *     joinColumns={@ORM\JoinColumn(name="pchelovod_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="pchelosezon_id", referencedColumnName="id")}
     * )
     */
    private $pchelosezons;

    /**
     * Pchelovod constructor.
     * @param PcheloMatka $pchelomatka
     * @param Uchastie $uchastie
     * @param ArrayCollection|Pchelosezon[] $pchelosezons
     * @throws \Exception
     */
    public function __construct(PcheloMatka $pchelomatka, Uchastie $uchastie ,
                                array $pchelosezons)
    {
        $this->guardPchelosezons($pchelosezons);
        $this->id = Uuid::uuid4()->toString();
        $this->pchelomatka = $pchelomatka;
        $this->uchastie = $uchastie;
        $this->pchelosezons = new ArrayCollection($pchelosezons);
    }
    /**
     * @param Pchelosezon[] $pchelosezons
     */
    public function changePchelosezons(array $pchelosezons): void
    {
        $this->guardPchelosezons($pchelosezons);

        $current = $this->pchelosezons->toArray();
        $new = $pchelosezons;

        $compare = static function (Pchelosezon $a, Pchelosezon $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->pchelosezons->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->pchelosezons->add($item);
        }
    }


    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function isForPchelosezon(PchelosezonId $id): bool
    {
        foreach ($this->pchelosezons as $pchelosezon) {
            if ($pchelosezon->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getPchelomatka(): PcheloMatka
    {
        return $this->pchelomatka;
    }

    /**
     * @return Pchelosezon[]
     */
    public function getPchelosezons(): array
    {
        return $this->pchelosezons->toArray();
    }

    public function guardPchelosezons(array $pchelosezons): void
    {
        if (\count($pchelosezons) === 0) {
            throw new \DomainException('Установите хотя бы один сезон.');
        }
    }

}