<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
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

	
	public function __construct(string $oblast)
    {
        $this->oblast = $oblast;
    }
}