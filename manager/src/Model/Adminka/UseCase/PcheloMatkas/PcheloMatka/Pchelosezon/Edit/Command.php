<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Edit;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Pchelosezon\Pchelosezon;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $pchelomatka;
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $pchelomatka, string $id)
    {
        $this->pchelomatka = $pchelomatka;
        $this->id = $id;
    }

    public static function fromPchelosezon(PcheloMatka $pchelomatka, Pchelosezon $department): self
    {
        $command = new self($pchelomatka->getId()->getValue(), $department->getId()->getValue());
        $command->name = $department->getName();
        return $command;
    }
}
