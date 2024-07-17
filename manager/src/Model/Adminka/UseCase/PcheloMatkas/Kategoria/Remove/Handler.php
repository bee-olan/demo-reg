<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\Kategoria\Remove;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatkaRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\KategoriaRepository;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Id;

class Handler
{
    private $kategorias;
    private $plemmatkas;
    private $flusher;

    public function __construct(KategoriaRepository $kategorias, PcheloMatkaRepository $plemmatkas, Flusher $flusher)
    {

        $this->kategorias = $kategorias;
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategoria = $this->kategorias->get(new Id($command->id));

//        if ($this->plemmatkas->hasUchastiesWithKategoria($kategoria->getId())) {
//            throw new \DomainException('Роль содержит участников.');
//        }

        $this->kategorias->remove($kategoria);

        $this->flusher->flush();
    }
}
