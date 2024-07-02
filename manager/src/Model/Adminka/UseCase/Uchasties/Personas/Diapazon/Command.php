<?php


namespace App\Model\Adminka\UseCase\Uchasties\Personas\Diapazon;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $diapazon;


}