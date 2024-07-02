<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Group\Remove;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Flusher;
use App\Model\Adminka\Entity\Uchasties\Group\GroupRepository;
use App\Model\Adminka\Entity\Uchasties\Group\Id;
use App\Model\Work\Entity\Members\Member\MemberRepository;


class Handler
{
    private $groups;
    private $uchasties;
    private $flusher;

    public function __construct(GroupRepository $groups,
                                UchastieRepository $uchasties,
                                Flusher $flusher)
    {
        $this->groups = $groups;
        $this->uchasties = $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $group = $this->groups->get(new Id($command->id));

         if ($this->uchasties->hasByGroup($group->getId())) {
             throw new \DomainException('Группа не пуста.');
         }


        $this->groups->remove($group);

        $this->flusher->flush();
    }
}
