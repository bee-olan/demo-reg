<?php

declare(strict_types=1);

namespace App\Menu\Adminka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MainMenu
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

        $menu
            ->addChild('Сезон!!! ', ['route' => 'adminka.sezons.godas'])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        $menu
            ->addChild('ПлемМатки ', ['route' => 'adminka.matkas'])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

//        $menu
//            ->addChild('Раса-Линия_Номер', ['route' => 'adminka.rasas'])
//            ->setExtra('routes', [
//                ['route' => 'adminka.rasas'],
//                ['pattern' => '/^adminka.rasas\..+/']
//            ])
//            ->setAttribute('class', 'nav-item ')
//            ->setLinkAttribute('class', 'nav-link ');


        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {


            $menu
                ->addChild('Категории', ['route' => 'adminka.pchelomatkas.kategorias'])
                ->setExtra('routes', [
                    ['route' => 'adminka.pchelomatkas.kategorias'],
                    ['pattern' => '/^adminka.pchelomatkas.kategorias\..+/']
                ])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');


//            $menu
//                ->addChild('Роли', ['route' => 'adminka.matkas.roles'])
//                ->setExtra('routes', [
//                    ['route' => 'adminka.matkas.roles'],
//                    ['pattern' => '/^adminka.matkas.roles\..+/']
//                ])
//                ->setAttribute('class', 'nav-item')
//                ->setLinkAttribute('class', 'nav-link');
        }

//        $menu
//            ->addChild('ДочьМатки - список', ['route' => 'adminka.matkas.childmatkas'])
//            ->setExtra('routes', [
//                ['route' => 'adminka.matkas.childmatkas'],
//                ['pattern' => '/^adminka.matkas.childmatkas\..+/']
//            ])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');
//
//        return $menu;

    }
}