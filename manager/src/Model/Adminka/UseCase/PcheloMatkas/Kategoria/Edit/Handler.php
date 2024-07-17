<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\Kategoria\Edit;

use App\Model\Flusher;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Id;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\KategoriaRepository;

class Handler
{
    private $kategorias;
    private $flusher;

    public function __construct(KategoriaRepository $kategorias, Flusher $flusher)
    {
        $this->kategorias = $kategorias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategoria = $this->kategorias->get(new Id($command->id));

        $kategoria->edit($command->name, $command->permissions);

        $this->flusher->flush();
    }
}
