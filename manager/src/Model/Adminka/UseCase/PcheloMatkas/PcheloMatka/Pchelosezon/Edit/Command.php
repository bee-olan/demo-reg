<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Edit;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $plemmatka, string $id)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
    }

    public static function fromDepartment(PlemMatka $plemmatka, Department $department): self
    {
        $command = new self($plemmatka->getId()->getValue(), $department->getId()->getValue());
        $command->name = $department->getName();
        return $command;
    }
}
