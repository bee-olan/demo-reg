<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod\Add;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;

use App\Model\Flusher;

//use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
//use App\Model\Adminka\Entity\Matkas\Role\Role;
//use App\Model\Adminka\Entity\Matkas\Role\Id as RoleId;
//use App\Model\Adminka\Entity\Matkas\Role\RoleRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\PcheloMatkas\pcheloMatka\Pchelosezon\Id as PchelosezonId;
use App\ReadModel\Adminka\PcheloMatkas\PchelosezonFetcher;

class Handler
{
    private $pchelomatkas;
    private $uchasties;
    private $pcheloFet;
    private $flusher;

    public function __construct(
        PcheloMatkaRepository $pchelomatkas,
        UchastieRepository $uchasties,
        PchelosezonFetcher $pcheloFet,
        Flusher $flusher
    )
    {
        $this->pchelomatkas = $pchelomatkas;
        $this->uchasties = $uchasties;
        $this->pcheloFet = $pcheloFet;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $pchelomatka = $this->pchelomatkas->get(new Id($command->pchelomatka));

//
        $uchastieId = $pchelomatka->getPersona()->getId()->getValue();
        $uchastie = $this->uchasties->get(new UchastieId($uchastieId));
//        dd($uchastie);
        $godaVixod = (string)$pchelomatka->getGodaVixod();

        $command->pchelosezon = $this->pcheloFet->getPchelosezonId($command->pchelomatka, $godaVixod);

//        $pchelosezons = array_map(static function (string $id): PchelosezonId {
//            return new PchelosezonId($id);
//        }, $command->pchelosezons);

        $pchelosezons = [0 => (new PchelosezonId($command->pchelosezon))];

        $pchelomatka->addUchastie($uchastie, $pchelosezons);

        $this->flusher->flush();
    }
}

