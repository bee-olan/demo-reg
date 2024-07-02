<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Personas\Create;

use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Personas\Persona;
use App\Model\Adminka\Entity\Uchasties\Personas\Id;
//use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;

class Handler
{
    private $personas;
    private $flusher;

    public function __construct(PersonaRepository $personas, Flusher $flusher)
    {
        $this->personas = $personas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);
        //dd($id);
        $persona = new Persona(
            $id,
            $command->nomer
        );

        $this->personas->add($persona);

        $this->flusher->flush();
    }
}
