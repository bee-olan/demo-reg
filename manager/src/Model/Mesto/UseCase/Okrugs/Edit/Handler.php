<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Edit;

use App\Model\Flusher;
use App\Model\Mesto\Entity\Okrugs\Id;
use App\Model\Mesto\Entity\Okrugs\OkrugRepository;

class Handler
{
    private $okrugs;
    private $flusher;

    public function __construct(OkrugRepository $okrugs, Flusher $flusher)
    {
        $this->okrugs = $okrugs;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $okrug = $this->okrugs->get(new Id($command->id));

        $okrug->edit($command->name, $command->nomer);

        $this->flusher->flush();
    }
}
