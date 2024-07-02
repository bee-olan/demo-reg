<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
	/**
     * @Assert\NotBlank()
     */
    public $okrug;
	
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $okrug, string $id)
    {
		$this->okrug = $okrug;
        $this->id = $id;
    }
}
