<?php

declare(strict_types=1);

namespace App\Menu\Proekts\PageGlavas\PcheloMatka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ChildMenu
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
            ->addChild('ПчелоДочь', ['route' => 'app.proekts.page_glavas.pchelomatka.childs.show'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.page_glavas.pchelomatka.childs'],
                ['pattern' => '/^app.proekts.page_glavas.pchelomatka.childs\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Список!', ['route' => 'app.proekts.pasekas.childpchelos'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.childpchelos'],
                ['pattern' => '/^app.proekts.pasekas.childpchelos\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        return $menu;
    }

}