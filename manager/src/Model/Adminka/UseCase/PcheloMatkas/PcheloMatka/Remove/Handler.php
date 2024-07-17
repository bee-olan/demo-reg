<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Remove;

use App\Model\Flusher;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Id;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;

//use App\Model\Work\Entity\Projects\Project\Id;
//use App\Model\Work\Entity\Projects\Project\ProjectRepository;

class Handler
{
    private $plemmatkas;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->id));

        $plemmatka->getNomer()->activeOjidaet();

        $plemmatka->getNomer()->noVetka();

        $this->plemmatkas->remove($plemmatka);


        $this->flusher->flush();
    }
}