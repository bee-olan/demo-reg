<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Remove;

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

    public function __construct(string $plemmatka, string $id)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
    }
}

