<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod\Remove;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

class Handler
{
    private $plemmatkas;
    private $flusher;
    private $uchasties;

    public function __construct(
        PlemMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
        $this->uchasties = $uchasties;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $plemmatka->removeUchastie($uchastie->getId());

        $this->flusher->flush();
    }
}

