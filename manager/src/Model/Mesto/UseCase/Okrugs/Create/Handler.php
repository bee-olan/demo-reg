<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Create;

use App\Model\Flusher;
use App\Model\Mesto\Entity\Okrugs\Okrug;
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
        $okrug = new Okrug(
            Id::next(),
            $command->name,
			$command->nomer

        );

        $this->okrugs->add($okrug);

        $this->flusher->flush();
    }
}
