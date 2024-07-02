<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Edit;


use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
	/**
     * @Assert\NotBlank()
     */
    public $okrug;
	
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
	
	/**
     * @var string
     * @Assert\NotBlank()
     */
    public $mesto;

    public function __construct(string $okrug, string $id)
    {
        $this->okrug = $okrug;
		$this->id = $id;
    }

    public static function fromOblast(Okrug $okrug, Oblast $oblast): self
    {
        $command = new self($okrug->getId()->getValue(), $oblast->getId()->getValue());
        $command->name = $oblast->getName();
		$command->nomer = $oblast->getNomer();
		$command->mesto = $oblast->getMesto();
        return $command;
    }
}
