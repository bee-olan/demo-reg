<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs\Oblasts;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Id as RaionId;

use App\Model\Mesto\Entity\Okrugs\Okrug;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mesto_okrug_oblasts")
 */
class Oblast
{
    /**
     * @var Okrug
     * @ORM\ManyToOne(targetEntity="App\Model\Mesto\Entity\Okrugs\Okrug", inversedBy="oblasts")
     * @ORM\JoinColumn(name="okrug_id", referencedColumnName="id", nullable=false)
     */
    private $okrug;

    /**
     * @var Id
     * @ORM\Column(type="mesto_okrug_oblast_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $mesto;


    /**
     * @var ArrayCollection|Raion[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion",
     *     mappedBy="oblast", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $raions;

    public function __construct(Okrug $okrug,
                                Id $id,
                                string $name,
                                string $nomer,
                                string $mesto
    )
    {
        $this->okrug = $okrug;
        $this->id = $id;
        $this->name = $name;
        $this->nomer = $nomer;
        $this->mesto = $mesto;
        $this->raions = new ArrayCollection();
    }

    public function edit(string $name, string $nomer , string $mesto): void
    {
        $this->name = $name;
        $this->nomer = $nomer;
        $this->mesto = $mesto;
    }

    //------------------------------>isNameEqual($name)
    public function addRaion(  RaionId $id,
                               string $name,
                               string $nomer,
                               string $mesto
                                ): void
    {
        foreach ($this->raions as $raion) {
            if ($raion->isNameEqual($name)) {
                throw new \DomainException('Такое название района - существует.');
            }
            if ($raion->isNomerEqual($nomer)) {
                throw new \DomainException('Такой номер района - уже существует.');
            }
        }
        $this->raions->add(new Raion($this, $id, $name, $nomer, $mesto));
    }
    public function editRaion(RaionId $id, string $name, $nomer, $mesto): void
    {
        foreach ($this->raions as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $nomer, $mesto);
                return;
            }
        }
        throw new \DomainException('Названия района - нет в базе данных .');
    }
    public function removeRaion(RaionId $id): void
    {
        foreach ($this->raions as $raion) {
            if ($raion->getId()->isEqual($id)) {
                $this->raions->removeElement($raion);
                return;
            }
        }
        throw new \DomainException('нет района.');
    }

// равно Ли Имя
    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNomerEqual(string $nomer): bool
    {
        return $this->nomer === $nomer;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNomer(): string
    {
        return $this->nomer;
    }

    public function getMesto(): string
    {
        return $this->mesto;
    }

    public function getOkrug(): Okrug
    {
        return $this->okrug;
    }


    public function getRaions()
    {
        return $this->raions->toArray();
    }

    public function getRaion(RaionId $id): Raion
    {
        foreach ($this->raions as $raion) {
            if ($raion->getId()->isEqual($id)) {
                return $raion;
            }
        }
        throw new \DomainException('нет такого района.');
    }
}