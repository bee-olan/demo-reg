<?php

declare(strict_types=1);

namespace App\Widget\Adminka\Matkas\ChildMatka;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PriorityWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('paseka_matkas_childmatka_priority', [$this, 'priority'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function priority(Environment $twig, string $priority): string
    {
        return $twig->render('widget/adminka/matkas/childmatka/priority.html.twig', [
            'priority' => $priority
        ]);
    }
}
