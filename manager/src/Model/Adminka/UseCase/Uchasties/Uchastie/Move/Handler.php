<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Uchastie\Move;

use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Group\GroupRepository;
use App\Model\Adminka\Entity\Uchasties\Group\Id as GroupId;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

class Handler
{
    private $uchasties;
    private $groups;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, GroupRepository $groups, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $uchastie = $this->uchasties->get(new Id($command->id));
        $group = $this->groups->get(new GroupId($command->group));

        $uchastie->move($group);

        $this->flusher->flush();
    }
}