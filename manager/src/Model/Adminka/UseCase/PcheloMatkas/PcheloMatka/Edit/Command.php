<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Edit;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $content;



    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPcheloMatka(PcheloMatka $pchelomatka): self
    {
        $command = new self($pchelomatka->getId()->getValue());
        $command->content = $pchelomatka->getContent();

        return $command;
    }
}
