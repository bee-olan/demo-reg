<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Edit;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Id;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
	/**
     * @Assert\NotBlank()
     */
    public $oblast;
	
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


    public function __construct(string $oblast, string $id)
    {
        $this->oblast = $oblast;
		$this->id = $id;
    }

    public static function fromRaion(Oblast $oblast, Raion $raion): self
    {
        $command = new self($oblast->getId()->getValue(), $raion->getId()->getValue());
        $mest = explode("-", $raion->getMesto());

        $command->name = $raion->getName();
		$command->nomer = $raion->getNomer();
		$command->mesto = $mest[0]."-".$mest[1];

        return $command;
    }
}
