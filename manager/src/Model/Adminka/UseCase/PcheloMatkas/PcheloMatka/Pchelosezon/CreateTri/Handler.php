<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\CreateTri;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Flusher;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id AS PcheloMatkaId;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Id ;

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
        $pchelomatka = $this->pchelomatkas->get(new PcheloMatkaId($command->pchelomatka));

        $nameGod = $pchelomatka->getGodaVixod() ;


            for ($i = 1; $i < 4; $i++) {
                $name = (int)$nameGod + $i-1;

                $pchelomatka->addPchelosezon(
                    Id::next(),
                    (string)$name
                );
            }

        $this->flusher->flush();

    }
}
