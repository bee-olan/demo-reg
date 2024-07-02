<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Create;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Id;
use App\Model\Mesto\Entity\Okrugs\OkrugRepository;
use App\Model\Mesto\Entity\Okrugs\Id as OkrugId;

use App\Model\Flusher;

class Handler
{
    private $oblasts;
    private $flusher;

    public function __construct(OkrugRepository $okrugs, Flusher $flusher)
    {
        $this->okrugs = $okrugs;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
		$okrug = $this->okrugs->get(new OkrugId($command->okrug));
		
        $okrug ->addOblast(
            Id::next(),
            $command->name,
			$command->nomer,
            $command->mesto = $command->mesto."-".$command->nomer
        );

        $this->flusher->flush();
    }
}
