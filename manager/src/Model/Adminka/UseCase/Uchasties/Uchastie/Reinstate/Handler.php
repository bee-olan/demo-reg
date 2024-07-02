<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Uchastie\Reinstate;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

class Handler
{
    private $uchastie;
    private $flusher;

    public function __construct(UchastieRepository $uchastie, Flusher $flusher)
    {
        $this->uchastie = $uchastie;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $uchastie = $this->uchastie->get(new Id($command->id));

        $uchastie->reinstate();

        $this->flusher->flush();
    }
}
