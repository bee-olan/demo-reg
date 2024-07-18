<?php

declare(strict_types=1);

namespace App\Model\Drevos\UseCase\Rass\Edit;

use App\Model\Drevos\Entity\Rass\Ras;
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

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

   public static function fromRasa(Ras $rasa): self
    {
       $command = new self($rasa->getId()->getValue());
       $command->name = $rasa->getName();
       $command->title = $rasa->getTitle();
       return $command;
    }
}
