<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Uchastie\Move;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $group;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUchastie(Uchastie $uchastie): self
    {
        $command = new self($uchastie->getId()->getValue());
        $command->group = $uchastie->getGroup()->getId()->getValue();
        return $command;
    }
}
