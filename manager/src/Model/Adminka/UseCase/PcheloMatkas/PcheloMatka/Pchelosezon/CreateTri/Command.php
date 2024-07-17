<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\CreateTri;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $pchelomatka;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;

    public function __construct(string $pchelomatka)
    {
        $this->pchelomatka = $pchelomatka;
    }
}
