<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
	/**
     * @Assert\NotBlank()
     */
    public $oblast;
	
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $oblast, string $id)
    {
		$this->oblast = $oblast;
        $this->id = $id;
    }
}
