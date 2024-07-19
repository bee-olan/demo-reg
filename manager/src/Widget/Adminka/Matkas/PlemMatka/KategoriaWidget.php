<?php

declare(strict_types=1);

namespace App\Widget\Adminka\Matkas\PlemMatka;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class KategoriaWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('plemmatka_kategoria', [$this, 'kategoria'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function kategoria(Environment $twig, string $kategoria): string
    {
        return $twig->render('widget/adminka/matkas/plemmatka/kategoria.html.twig', [
            'kategoria' => $kategoria
        ]);
    }
}

