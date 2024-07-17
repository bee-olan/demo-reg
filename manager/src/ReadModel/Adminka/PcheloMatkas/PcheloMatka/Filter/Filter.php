<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\Filter;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Status;

class Filter
{
    public $uchastie;
    public $name;
    public $goda_vixod;
    public $kategoria;
    public $persona;
    public $status = Status::ACTIVE;


    private function __construct(?string $uchastie)
    {
        $this->uchastie = $uchastie;
    }

    public static function allPagin(): self
    {
        return new self(null);
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