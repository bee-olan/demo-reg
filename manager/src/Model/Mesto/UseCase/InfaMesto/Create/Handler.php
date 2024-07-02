<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\InfaMesto\Create;

use App\Model\Flusher;
use App\Model\Mesto\Entity\InfaMesto\MestoNomer;
use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;


class Handler
{
    private $mestonomers;
    private $flusher;

    public function __construct(MestoNomerRepository $mestonomers, Flusher $flusher)
    {
        $this->mestonomers = $mestonomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $id = new Id($command->id);

        $mestonomer = new MestoNomer(
            $id,
            $command->raionId,
            $command->nomer
        );

        $this->mestonomers->add($mestonomer);

        $this->flusher->flush();
    }
}

