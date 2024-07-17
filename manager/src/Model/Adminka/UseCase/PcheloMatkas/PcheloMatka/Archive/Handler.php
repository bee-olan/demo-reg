<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Archive;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;
use App\Model\Flusher;


class Handler
{
    private $pchelomatkas;
    private $flusher;

    public function __construct(PcheloMatkaRepository $pchelomatkas, Flusher $flusher)
    {
        $this->pchelomatkas = $pchelomatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $pchelomatka = $this->pchelomatkas->get(new Id($command->id));


        $pchelomatka->archive();

        $this->flusher->flush();
    }
}