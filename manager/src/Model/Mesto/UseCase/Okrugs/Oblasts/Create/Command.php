<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Create;

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

	
	public function __construct(string $okrug)
    {
        $this->okrug = $okrug;
    }
}