<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Remove;

use App\Model\Flusher;

use App\Model\Mesto\Entity\Okrugs\Oblasts\OblastRepository;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Id as RaionId;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Id;

class Handler
{
    private $oblasts;
    private $flusher;

    public function __construct(OblastRepository $oblasts, Flusher $flusher)
    {
        $this->oblasts = $oblasts;
        //$this->u4astniki = $u4astniki;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $oblast = $this->oblasts->get(new Id($command->oblast));

		$oblast->removeRaion(new RaionId($command->id));

        $this->flusher->flush();
    }
}
