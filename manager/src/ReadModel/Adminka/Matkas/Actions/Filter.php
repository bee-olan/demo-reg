<?php

declare(strict_types=1);

namespace App\ReadModel\Adminka\Matkas\Actions;


class Filter
{
    public $uchastie;
    public $plemmatka;

    private function __construct(?string $plemmatka)
    {
        $this->plemmatka = $plemmatka;
    }

    public static function forPlemMatka(string $plemmatka): self
    {
        return new self($plemmatka);
    }

    public static function all(): self
    {
        return new self(null);
    }

    public function forUchastie(string $uchastie): self
    {
        $clone = clone $this;
        $clone->uchastie = $uchastie;
        return $clone;
    }
}

