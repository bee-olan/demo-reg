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
    private $pchelomatkas;
    private $flusher;

    public function __construct(KategoriaRepository $kategorias, PcheloMatkaRepository $pchelomatkas, Flusher $flusher)
    {

        $this->kategorias = $kategorias;
        $this->pchelomatkas = $pchelomatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategoria = $this->kategorias->get(new Id($command->id));

        if ($this->pchelomatkas->hasPchelMatkaWithKategor($kategoria->getId())) {
            throw new \DomainException('Категория  содержится в  пчело - матке.');
        }

        $this->kategorias->remove($kategoria);

        $this->flusher->flush();
    }
}
