<?php

declare(strict_types=1);

namespace App\Service\Adminka\Processor;

use App\Service\Adminka\Processor\Driver\Driver;

class Processor
{
    /**
     * @var Driver[]
     */
    private $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = $drivers;
    }

    public function process(?string $text): string
    {
        $result = $text;
        foreach ($this->drivers as $driver) {
            $result = $driver->process($result);
        }
        return $result;
    }
}
