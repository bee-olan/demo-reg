<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Personas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $nomer;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

}