<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\Uchasties\Uchastie\Edit;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
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
    public $nike;

     /**
      * @var string
      * @Assert\Email()
      */
     public $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUchastie(Uchastie $uchastie): self
    {
        $command = new self($uchastie->getId()->getValue());
        $command->nike = $uchastie->getNike();
         $command->email = $uchastie->getEmail()->getValue();
        return $command;
    }
}
