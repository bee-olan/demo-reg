<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Reinstate;

use App\Model\Flusher;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;

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

        $pchelomatka->reinstate();

        $this->flusher->flush();
    }
}