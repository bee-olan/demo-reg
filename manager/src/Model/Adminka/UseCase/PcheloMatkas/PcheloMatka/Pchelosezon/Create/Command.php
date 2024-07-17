<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelosezon\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $pchelomatka;

    /**
     * @var int
     */
    public $maxpchelo;

    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $pchelomatka,  int $maxpchelo)
    {
        $this->pchelomatka = $pchelomatka;
        $this->maxpchelo = $maxpchelo;
    }
}
