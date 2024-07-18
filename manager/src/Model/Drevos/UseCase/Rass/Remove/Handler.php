<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Remove;

use App\Model\Flusher;
use App\Model\Drevos\Entity\Rass\Id;
use App\Model\Drevos\Entity\Rass\RasRepository;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->id));

        $this->rasas->remove($rasa);

        $this->flusher->flush();
    }
}
