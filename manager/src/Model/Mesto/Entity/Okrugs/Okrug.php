<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Id as OblastId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="mesto_okrugs")
 */
class Okrug
{

    /**
     * @var Id
     * @ORM\Column(type="mesto_okrug_id")
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
      * @var ArrayCollection|Oblast[]
      * @ORM\OneToMany(
      *     targetEntity="App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast",
      *     mappedBy="okrug", orphanRemoval=true, cascade={"all"}
      * )
      * @ORM\OrderBy({"name" = "ASC"})
      */
     private $oblasts;

    public function __construct( Id $id,
                                 string $name,
                                 string $nomer
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->nomer = $nomer;
		$this->oblasts = new ArrayCollection();
    }

    public function edit(string $name, string $nomer): void
    {
        $this->name = $name;
        $this->nomer = $nomer;
    }
//------------------------------
public function addOblast(  OblastId $id,
                            string $name,
                            string $nomer,
                            string $mesto
                            ): void
    {
        foreach ($this->oblasts as $oblast) {
            if ($oblast->isNameEqual($name)) {
                throw new \DomainException('Такое название - существует.');
            }
			if ($oblast->isNomerEqual($nomer)) {
                throw new \DomainException('Такой номер - существует.');
            }
        }
        $this->oblasts->add(new Oblast($this, $id, $name, $nomer, $mesto));
    }

    public function editOblast(OblastId $id, string $name, string $nomer, string $mesto): void
    {
        foreach ($this->oblasts as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name, $nomer, $mesto);
                return;
            }
        }
        throw new \DomainException('номер не найден.');
    }

    public function removeOblast(OblastId $id): void
    {
        foreach ($this->oblasts as $oblast) {
            if ($oblast->getId()->isEqual($id)) {
                $this->oblasts->removeElement($oblast);
                return;
            }
        }
        throw new \DomainException('Округ не найден.');
    }

//равно Ли Имя ТАК ПОНЯЛА ЭТО должно быть  В Oblast-----------------------
//    public function isNameEqual(string $name): bool
//    {
//        return $this->name === $name;
//    }
//
//    public function isNomerEqual(string $nomer): bool
//    {
//        return $this->nomer === $nomer;
//    }


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
    public function getOblasts()
    {
        return $this->oblasts->toArray();
    }

	public function getOblast(OblastId $id): Oblast
    {
        foreach ($this->oblasts as $oblast) {
            if ($oblast->getId()->isEqual($id)) {
                return $oblast;
            }
        }
        throw new \DomainException('oblast is not found.');
    }
}