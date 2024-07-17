<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod\EditSez;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Id as PchelosezonId;
use App\Model\Flusher;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

class Handler
{
    private $pchelomatkas;
    private $uchasties;
    private $flusher;

    public function __construct(
        PcheloMatkaRepository $pchelomatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->pchelomatkas = $pchelomatkas;
        $this->uchasties = $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $pchelomatka = $this->pchelomatkas->get(new Id($command->pchelomatka)) ;

        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $pchelosezons = array_map(static function (string $id): PchelosezonId {
            return new PchelosezonId($id);
        }, $command->pchelosezons);

        $pchelomatka->editSezonUchastie($uchastie->getId(), $pchelosezons);

        $this->flusher->flush();
    }
}

