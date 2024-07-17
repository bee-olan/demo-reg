<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\Kategoria\Create;

use App\Model\Flusher;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Kategoria;
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
//        if ($this->kategorias->hasByName($command->name)) {
//            throw new \DomainException('Kategoria already exists.');
//        }

//dd($command);
        $kategoria = new Kategoria(
            Id::next(),
            $command->name,
            $command->permissions
        );

        $this->kategorias->add($kategoria);

        $this->flusher->flush();
    }
}
