<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Edit;

use App\Model\Flusher;

use App\Model\Mesto\Entity\Okrugs\Id ;
use App\Model\Mesto\Entity\Okrugs\Oblasts\OblastRepository;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Id as OblastId;

class Handler
{
    private $oblasts;
    private $flusher;

    public function __construct(OblastRepository $oblasts, Flusher $flusher)
    {
        $this->oblasts = $oblasts;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $oblast = $this->oblasts->get(new OblastId($command->id));


        $oblast->edit($command->name, $command->nomer, $command->mesto);

        $this->flusher->flush();
    }
}
