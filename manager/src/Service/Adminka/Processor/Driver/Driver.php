<?php

declare(strict_types=1);

namespace App\Service\Adminka\Processor\Driver;

interface Driver
{
    public function process(string $text): string;
}
