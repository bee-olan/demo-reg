<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\PlemMatka\Filter;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
    public $persona;
    public $status = Status::ACTIVE;
    public $god_vixod;
//    public $kategoria;
    public $uchastie;


    private function __construct(?string $uchastie)
    {
        $this->uchastie = $uchastie;
    }

    public static function all(): self
    {
        return new self(null);
    }

    public static function forUchastie(string $id): self
    {
        return new self($id);
    }
}