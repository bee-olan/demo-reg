<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Remove;

use App\Model\Flusher;
use App\Model\Mesto\Entity\Okrugs\OkrugRepository;
use App\Model\Mesto\Entity\Okrugs\Id;


class Handler
{
    private $okrugs;
    //private $u4astniki;
    private $flusher;

    public function __construct(OkrugRepository $okrugs,
                                //U4astnikRepository  $u4astniki,
                                Flusher $flusher)
    {
        $this->okrugs = $okrugs;
        //$this->u4astniki = $u4astniki;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $okrug = $this->okrugs->get(new Id($command->id));

        // if ($this->u4astniki->hasByGroup($okrug->getId())) {
        //     throw new \DomainException('Mesto is not empty.');
        // }


        $this->okrugs->remove($okrug);

        $this->flusher->flush();
    }
}
