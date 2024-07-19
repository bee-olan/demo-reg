<?php

declare(strict_types=1);

namespace App\Widget\Adminka\Matkas\ChildMatka;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TypeWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('paseka_matkas_childmatka_type', [$this, 'type'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function type(Environment $twig, string $type): string
    {
        return $twig->render('widget/adminka/matkas/childmatka/type.html.twig', [
            'type' => $type
        ]);
    }
}
