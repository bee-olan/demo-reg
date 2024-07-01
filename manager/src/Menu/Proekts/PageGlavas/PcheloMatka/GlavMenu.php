<?php

declare(strict_types=1);

namespace App\Menu\Proekts\PageGlavas\PcheloMatka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GlavMenu
{
    private $factory;
    private $auth;

    public function __construct(FactoryInterface $factory, AuthorizationCheckerInterface $auth)
    {
        $this->factory = $factory;
        $this->auth = $auth;
    }

    public function build(): ItemInterface
    {

        $menu = $this->factory->createItem('root')
            ->setChildrenAttributes(['class' => 'nav_pro nav_pro-tabs mb-4']);

        $menu
            ->addChild('ПчелоМатка', ['route' => 'app.proekts.page_glavas.pchelomatka.show'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.page_glavas.pchelomatka.show'],

            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Список', ['route' => 'app.proekts.pasekas.pchelomatkas.spisoks'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.pchelomatkas'],
                ['route' => 'app.proekts.pasekas.pchelomatkas.spisoks'],
                ['pattern' => '/^app.proekts.page_glavas.pchelomatkas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Категории.Трут фон.', ['route' => 'app.proekts.pasekas.pchelomatkas.kategoris.kategor'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.pchelomatkas.kategoris.kategor'],
                ['pattern' => '/^app.proekts.pasekas.pchelomatkas.kategoris.kategor\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Регистрация.', ['route' => 'app.proekts.pasekas.pchelomatkas.pchelomatka.creates.create'])
//            ->addChild('Регистрация.', ['route' => 'app.proekts.pasekas.pchelomatkas.creates.create'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.pchelomatkas.pchelomatka.creates.create'],

                ['pattern' => '/^app.proekts.pasekas.pchelomatkas.pchelomatka.creates\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');


        return $menu;
    }

}