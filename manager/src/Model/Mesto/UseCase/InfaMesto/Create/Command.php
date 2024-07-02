<?php

declare(strict_types=1);


namespace App\Model\Mesto\UseCase\InfaMesto\Create;

use App\Model\User\Entity\User\User;
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
    public $raionId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $nomer;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
    public static function fromMesto($command, string $raion_id, string $mestonomer): self
    {

        $command->nomer = $mestonomer;
        $command->raionId = $raion_id;
        return $command;

    }
}