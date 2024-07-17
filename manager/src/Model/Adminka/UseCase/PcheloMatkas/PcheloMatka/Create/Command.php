<?php

declare(strict_types=1);

namespace App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $sort;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $personNom;

    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $date_vixod;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastieId;

    /**
     * @var string
     */
    public $content;

    /**
     * @Assert\NotBlank()
     */
    public $kategoria;

    /**
     * @Assert\NotBlank()
     */
    public $rasa;

    public function __construct( string $uchastieId, int $sort )
    {
        $this->sort = $sort;
        $this->uchastieId = $uchastieId;
    }
}
