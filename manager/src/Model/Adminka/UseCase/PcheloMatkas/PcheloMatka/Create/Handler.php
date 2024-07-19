<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Create;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\KategoriaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Id as KategoriaId;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;
use App\Model\Drevos\Entity\Rass\RasRepository;
use App\Model\Drevos\Entity\Rass\Id as RasaId;
use App\Model\Flusher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Drevos\Rass\RasFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

class Handler
{
    private $pchelomatkas;
    private $kategorias;
    private $personas;
    private $mestoNomers;
    private $rasas;
    private $flusher;

    public function __construct(PcheloMatkaRepository $pchelomatkas,
                                PersonaFetcher $personas,
                                MestoNomerFetcher $mestoNomers,
                                KategoriaRepository $kategorias,
                                RasRepository $rasas,
                                Flusher $flusher)
    {
        $this->pchelomatkas = $pchelomatkas;
        $this->kategorias = $kategorias;
        $this->rasas = $rasas;
        $this->personas = $personas;
        $this->mestoNomers = $mestoNomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $persona = $this->personas->find($command->uchastieId);

        $mesto = $this->mestoNomers->find($command->uchastieId);


        $command->godaVixod = (int)$command->date_vixod->format('Y');

        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));

        $rasaPchel = $this->rasas->get(new RasaId($command->rasa));
//        dd($rasaPchel->getName());

        $command->title = $command->personNom . "-" . $command->godaVixod;

        if ($this->pchelomatkas->hasByName($command->title)) {
            throw new \DomainException('В выбранном году, ПчелоМатка с таким номером - уже существует.');
        }


        $rasa = $rasaPchel->getName();

        if ($rasa == " -- нет нужной" and ($kategoria->getName() == "бр" || $kategoria->getName() == "бр/а" || $kategoria->getName() == "бр/с")) {
            throw new \DomainException('Забыли сделать выбор расы для Пчело - Матки');
        }

        if  ($kategoria->getName() == "м" || $kategoria->getName() == "м/а" || $kategoria->getName() == "м/с") {
            $rasa = "...";
        }

        $command->name = $rasa . "-" . $command->sort. " : " . $kategoria->getName()  . " : " . $mesto->getNomer() . "_пн-" . $persona->getNomer() . " : " . $command->title;

        $date = new \DateTimeImmutable();

        $pchelomatka = new PcheloMatka(
            Id::next(),
            $command->name,
            $command->sort,
            $command->title,
            $command->godaVixod,
            $command->date_vixod,
            $date,
            $mesto,
            $persona,
            $kategoria,
            $command->content
        );

        $this->pchelomatkas->add($pchelomatka);

        $this->flusher->flush();
    }
}
