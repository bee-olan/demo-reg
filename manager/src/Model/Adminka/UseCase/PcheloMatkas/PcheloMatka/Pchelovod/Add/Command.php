<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod\Add;

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
    public $uchastie;

    /**
     * @Assert\NotBlank()
     */
    public $pchelosezons;
//    /**
//     * @Assert\NotBlank()
//     */
//    public $roles;

    public function __construct(string $pchelomatka)
    {
        $this->pchelomatka = $pchelomatka;
    }
}
