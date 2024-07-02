<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Group\Edit;

use App\Model\Adminka\Entity\Uchasties\Group\Group;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromGroup(Group $group): self
    {
        $command = new self($group->getId()->getValue());
        $command->name = $group->getName();
        return $command;
    }
}
