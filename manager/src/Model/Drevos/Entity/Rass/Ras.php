<?php

declare(strict_types=1);

namespace App\Model\Drevos\Entity\Rass;

//use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
//use App\Model\Drevos\Entity\Rass\LiniBr\Id as LiniBrId;
//use App\Model\Drevos\Entity\Rass\Rods\Rod;
//use App\Model\Drevos\Entity\Rass\Rods\Id as RodId;
//use App\Model\Drevos\Entity\Strans\Stran;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dre_rass")
 */
class Ras
{
    /**
     * @var Id
     * @ORM\Column(type="dre_ras_id")
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
    private $title;
	
//	 /**
//     * @var ArrayCollection|Rod[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Drevos\Entity\Rass\Rods\Rod",
//     *     mappedBy="rasa", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"nameMatkov" = "ASC"})
//     */
//    private $rodos;

//    /**
//     * @var ArrayCollection|LiniBr[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Drevos\Entity\Rass\LiniBr\LiniBr",
//     *     mappedBy="rasa", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $linias;

    public function __construct(Id $id, string $name, string $title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
//
//		$this->rodos = new ArrayCollection();
//		$this->linias = new ArrayCollection();
    }

    public function edit(string $name, string $title): void
    {
        $this->name = $name;
        $this->title = $title;
    }
/////////////////////////////////////////////////////////////////////////
//    public function addLiniBr(LiniBrId $id,
//                             string $name,
//                             int $sortLiniBr,
//                             ?LiniBr $roditBr
//    ): void
//    {
//        foreach ($this->linias as $linia) {
//            if ($linia->isNameEqual($name)) {
//                throw new \DomainException('Линия уже существует. Попробуйте для
//                этой линии добавить свой номер');
//            }
//        }
//
//        $this->linias->add(new LiniBr($this,
//            $id,
//            $name,
//            $sortLiniBr,
//            $roditBr
//        ));
//    }
//
//    public function editLiniBr(LiniBrId $id,
//                              string $name
//    ): void
//    {
//        foreach ($this->linias as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($name );
//                return;
//            }
//        }
//        throw new \DomainException('LiniBr is not found.');
//    }
//
//    public function removeLiniBr(LiniBrId $id): void
//    {
//        foreach ($this->linias as $linia) {
//            if ($linia->getId()->isEqual($id)) {
//                $this->linias->removeElement($linia);
//                return;
//            }
//        }
//        throw new \DomainException('LiniBr is not found.');
//    }
//
//    public function getLinias()
//    {
//        return $this->linias->toArray();
//    }
//
//
//    public function getLinia(LiniBrId $id): LiniBr
//    {
//        foreach ($this->linias as $linia) {
//            if ($linia->getId()->isEqual($id)) {
//                return $linia;
//            }
//        }
//        throw new \DomainException('LiniBr is not found.');
//    }
///////////////////////////////////////////////////////////////////////////////////
//    public function addRod(RodId $id,
//								int $sortRodo,
//                                string $nameMatkov,
//                                string $kodMatkov
//                                ): void
//    {
//
//        foreach ($this->rodos as $rodo) {
//
//            if ($rodo->isNameMatEqual($nameMatkov)) {
//                throw new \DomainException('Такой матковод уже записан. Нада выйти из режима "Добавить" - кнопка внизу');
//            }
//            if ($rodo->isKodMatkovEqual($kodMatkov)) {
//                throw new \DomainException('Ошибка в выборе кода. ');
//            }
//        }
//
//        $this->rodos->add(new Rod($this,
//									$id,
//									$sortRodo,
//                                    $nameMatkov,
//                                    $kodMatkov
//                                    ));
//    }
//
//    public function editRod(RodId $id,
//                                string $nameMatkov,
//                                string $kodMatkov
//                                ): void
//    {
//        foreach ($this->rodos as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($nameMatkov, $kodMatkov);
//                return;
//            }
//        }
//        throw new \DomainException('Rodo is not found.');
//    }
//
//    public function removeRod(RodId $id): void
//    {
//        foreach ($this->rodos as $rodo) {
//            if ($rodo->getId()->isEqual($id)) {
//                $this->rodos->removeElement($rodo);
//                return;
//            }
//        }
//        throw new \DomainException('Rodo is not found.');
//    }
//
//	 public function getRodos()
//    {
//        return $this->rodos->toArray();
//    }
//
//    public function getRodo(RodId $id): Rod
//    {
//        foreach ($this->rodos as $rodoo) {
//            if ($rodoo->getId()->isEqual($id)) {
//                return $rodoo;
//            }
//        }
//        throw new \DomainException('Rodo is not found.');
//    }
///////////////////////////////////////
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
}
