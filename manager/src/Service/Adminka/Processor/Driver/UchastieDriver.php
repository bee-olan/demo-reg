<?php

declare(strict_types=1);

namespace App\Service\Adminka\Processor\Driver;


use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
use Twig\Environment;

class UchastieDriver implements Driver
{
    private const PATTERN = '/\@[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i';

    private $uchasties;
    private $twig;

    public function __construct(UchastieFetcher $uchasties, Environment $twig)
    {
        $this->uchasties = $uchasties;
        $this->twig = $twig;
    }

    public function process(string $text): string
    {
        return preg_replace_callback(self::PATTERN, function (array $matches) {
            $id = ltrim($matches[0], '@');
            if (!$uchastie = $this->uchasties->find($id)) {
                return $matches[0];
            }
            return $this->twig->render('processor/adminka/uchastie.html.twig', [
                'uchastie' => $uchastie,
            ]);
        }, $text);
    }
}
