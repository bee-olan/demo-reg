<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Edit;

use App\Model\Mesto\Entity\Okrugs\Okrug;
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
    public $nomer;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromOkrug(Okrug $okrug): self
    {
        $command = new self($okrug->getId()->getValue());
        $command->name = $okrug->getName();
		$command->nomer = $okrug->getNomer();
        return $command;
    }
}
