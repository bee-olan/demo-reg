<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Edit;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;
use App\Model\Flusher;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;

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

        $pchelomatka->edit(
            $command->content
        );

        $this->flusher->flush();
    }
}
