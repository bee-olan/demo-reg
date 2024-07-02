<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Remove;

use App\Model\Flusher;

use App\Model\Mesto\Entity\Okrugs\OkrugRepository;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Id as OblastId;
use App\Model\Mesto\Entity\Okrugs\Id;



class Handler
{
    private $okrugs;
    private $flusher;

    public function __construct(OkrugRepository $okrugs, Flusher $flusher)
    {
        $this->okrugs = $okrugs;
        //$this->u4astniki = $u4astniki;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $okrug = $this->okrugs->get(new Id($command->okrug));

		$okrug->removeOblast(new OblastId($command->id));

        $this->flusher->flush();
    }
}
