<?php

declare(strict_types=1);

namespace App\Widget\Adminka\Matkas;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ActionRowWidget extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('adminka_matkas_action_row', [$this, 'row'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function row(Environment $twig, array $action): string
    {
        return $twig->render('widget/adminka/matkas/action-row.html.twig', compact('action'));
    }
}
