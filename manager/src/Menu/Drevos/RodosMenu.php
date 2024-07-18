<?php

declare(strict_types=1);

namespace App\Menu\Drevos;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RodosMenu
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
            ->setChildrenAttributes(['class' => 'nav nav-tabs mb-4']);

//        $menu
//            ->addChild('Страна (добавить)', ['route' => 'drevos.strans'])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('Родословная (создать)', ['route' => 'drevos.rass'])
            ->setExtra('routes', [
                ['route' => 'drevos.rass'],
                ['pattern' => '/^drevos.rass\..+/']
            ])
            ->setAttribute('class', 'nav-item ')
            ->setLinkAttribute('class', 'nav-link ');

//        $menu
//            ->addChild('Список родословных', ['route' => 'drevos.rodos'])
//            ->setExtra('routes', [
//                ['route' => 'drevos.rodos'],
//                ['pattern' => '/^drevos.rodos\..+/']
//            ])
//            ->setAttribute('class', 'nav-item ')
//            ->setLinkAttribute('class', 'nav-link ');

        $menu->addChild('Пчело-Матка', ['route' => 'adminka.pchelomatkas'])
            ->setExtra(
                'routes',
                [
                    ['route' => 'adminka.pchelomatkas'],
                    ['pattern' => '/^adminka\.pchelomatkas\..+/']
                ]
            )
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }

}