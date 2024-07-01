<?php

declare(strict_types=1);

namespace App\Menu\Proekts\PageGlavas\ElitMatka;

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
            ->addChild('ЕлитМатка', ['route' => 'app.proekts.page_glavas.elitmatka'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.page_glavas.elitmatka'],
                ['route' => 'app.proekts.pasekas.elitmatkas.redaktors'],
                ['pattern' => '/^app.proekts.page_glavas.elitmatka\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Список', ['route' => 'app.proekts.pasekas.elitmatkas.spisoks'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.elitmatkas'],
                ['route' => 'app.proekts.pasekas.elitmatkas.spisoks'],
                ['pattern' => '/^app.proekts.page_glavas.elitmatka\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');
        $menu
            ->addChild('Родословная', ['route' => 'app.proekts.drevorods.rodras'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.drevorods.rodras'],
                ['route' => 'app.proekts.drevorods.rods'],
                ['pattern' => '/^app.proekts.drevorods.rodras\..+/'],
                ['pattern' => '/^app.proekts.drevorods.rods\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Регистрация', ['route' => 'app.proekts.pasekas.elitmatkas.elitcreates'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.elitmatkas.elitcreates'],
                ['pattern' => '/^app.proekts.pasekas.elitmatkas.elitcreates\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Сезоны', ['route' => 'app.proekts.pasekas.elitmatkas.spisoks'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.elitmatkas.elitcreates'],
                ['pattern' => '/^app.proekts.pasekas.elitmatkas.elitmatka\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');


        return $menu;
    }

}