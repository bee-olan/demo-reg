<?php

declare(strict_types=1);

namespace App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Kategoria;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Id as PchelosezonId;
use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_pchelomats")
 */
class PcheloMatka
{
    /**
     * @var Id
     * @ORM\Column(type="admin_pchelomat_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var MestoNomer
     * @ORM\ManyToOne(targetEntity="App\Model\Mesto\Entity\InfaMesto\MestoNomer")
     * @ORM\JoinColumn(name="mesto_id", referencedColumnName="id", nullable=false)
     */
    private $mesto;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Persona
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\Uchasties\Personas\Persona")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
     */
    private $persona;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var Status
     * @ORM\Column(type="admin_pchelomat_status", length=16)
     */
    private $status;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $godaVixod;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $dateVixod;

    /**
     * @var Kategoria
     * @ORM\ManyToOne(targetEntity="App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Kategoria")
     * @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id", nullable=false)
     */
    private $kategoria;


    /**
     * @var ArrayCollection|Pchelosezon[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon",
     *     mappedBy="pchelomatka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $pchelosezons;

    /**
     * @var ArrayCollection|Pchelovod[]
     * @ORM\OneToMany(targetEntity="Pchelovod", mappedBy="pchelomatka", orphanRemoval=true, cascade={"all"})
     */
    private $pchelovods;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;


    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    public function __construct(Id $id,
                                string $name,
                                int $sort,
                                string $title,
                                int $godaVixod,
                                \DateTimeImmutable $dateVixod,
                                \DateTimeImmutable $date,
                                MestoNomer $mesto,
                                Persona $persona,
                                Kategoria $kategoria,
                                ?string $content
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->title = $title;
        $this->godaVixod = $godaVixod;
        $this->dateVixod = $dateVixod;
        $this->date = $date;
        $this->kategoria = $kategoria;
        $this->mesto = $mesto;
        $this->persona = $persona;
        $this->content = $content;
        $this->status = Status::active();

        $this->pchelosezons = new ArrayCollection();
        $this->pchelovods = new ArrayCollection();

    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function edit(string $content): void
    {
        $this->content = $content;
    }

    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('ПлемМатка уже заархивирована.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('ПлемМатка уже активена.');
        }
        $this->status = Status::active();
    }

    //////////////
    public function hasPchelosezon(PchelosezonId $id): bool
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForPchelosezon($id)) {
                return true;
            }
        }
        return false;
    }

    public function addPchelosezon(PchelosezonId $id, string $name): void
    {
        foreach ($this->pchelosezons as $pchelosezon) {
            if ($pchelosezon->isNameEqual($name)) {
                throw new \DomainException('Отдел уже существует.');
            }
        }
        $this->pchelosezons->add(new Pchelosezon($this, $id, $name));
    }

    public function editPchelosezon(PchelosezonId $id, string $name): void
    {
        foreach ($this->pchelosezons as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }

    public function removePchelosezon(PchelosezonId $id): void
    {
        foreach ($this->pchelosezons as $pchelosezon) {
            if ($pchelosezon->getId()->isEqual($id)) {
                foreach ($this->pchelovods as $pchelovod) {
                    if ($pchelovod->isForPchelosezon($id)) {
                        throw new \DomainException('Не удалось удалить отдел с участиемs.');
                    }
                }
                $this->pchelosezons->removeElement($pchelosezon);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }

    ///////

    public function hasUchastie(UchastieId $id): bool
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param Uchastie $uchastie
     * @param PchelosezonId[] $pchelosezonIds
     * @throws \Exception
     */
    public function addUchastie(Uchastie $uchastie, array $pchelosezonIds): void
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($uchastie->getId())) {
                throw new \DomainException('Такой участник уже добавлен.');
            }
        }
        $pchelosezons = array_map([$this, 'getPchelosezon'], $pchelosezonIds);
        $this->pchelovods->add(new Pchelovod($this, $uchastie, $pchelosezons));
    }

    /**
     * @param UchastieId $uchastie
     * @param PchelosezonId[] $pchelosezonIds
     */
    public function editUchastie(UchastieId $uchastie, array $pchelosezonIds): void
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($uchastie)) {
                $pchelovod->changePchelosezons(array_map([$this, 'getPchelosezon'], $pchelosezonIds));
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    /**
     * @param UchastieId $uchastie
     * @param PchelosezonId[] $pchelosezonIds
     */
    public function editSezonUchastie(UchastieId $uchastie, array $pchelosezonIds): void
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($uchastie)) {
                $pchelovod->changePchelosezons(array_map([$this, 'getPchelosezon'], $pchelosezonIds));
//                $pchelovod->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

    public function removeUchastie(UchastieId $uchastie): void
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($uchastie)) {
                $this->pchelovods->removeElement($pchelovod);
                return;
            }
        }
        throw new \DomainException('Участие не найдено.');
    }

// если есть у пользователя разрешение !!!!!!!!!!!!!!!!!!!!!!!!!
    public function isUchastieGranted(UchastieId $id, string $permission): bool
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($id)) {
                return $pchelovod->isGranted($permission);
            }
        }
        return false;
    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getGodaVixod(): int
    {
        return $this->godaVixod;
    }


    public function getDateVixod(): \DateTimeImmutable
    {
        return $this->dateVixod;
    }

    public function getPchelovods()
    {
        return $this->pchelovods->toArray();
    }

    public function getPchelovod(UchastieId $id): Pchelovod
    {
        foreach ($this->pchelovods as $pchelovod) {
            if ($pchelovod->isForUchastie($id)) {
                return $pchelovod;
            }
        }
        throw new \DomainException('Такого участника  нет.');
    }

    public function getKategoria(): Kategoria
    {
        return $this->kategoria;
    }

    public function getMesto(): MestoNomer
    {
        return $this->mesto;
    }

    public function getPersona(): Persona
    {
        return $this->persona;
    }

    public function getPchelosezons()
    {
        return $this->pchelosezons->toArray();
    }

    public function getPchelosezon(PchelosezonId $id): Pchelosezon
    {
        foreach ($this->pchelosezons as $pchelosezon) {
            if ($pchelosezon->getId()->isEqual($id)) {
                return $pchelosezon;
            }
        }
        throw new \DomainException('раздел  не найден.');
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

}
