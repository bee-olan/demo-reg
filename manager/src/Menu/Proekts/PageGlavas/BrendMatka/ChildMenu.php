<?php

declare(strict_types=1);

namespace App\Menu\Proekts\PageGlavas\BrendMatka;

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
            ->addChild('ДочьБренд', ['route' => 'app.proekts.page_glavas.brendmatka'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.page_glavas.brendmatka'],
//                ['route' => 'app.proekts.pasekas.matkas'],
                ['pattern' => '/^app.proekts.pasekas.matkas.plemmatkas.childmatka\..+/'],
                ['pattern' => '/^app.proekts.page_glavas.brendmatka\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Список ДочьМаток', ['route' => 'app.proekts.pasekas.childmatkas'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.pasekas.childmatkas'],
                ['pattern' => '/^app.proekts.pasekas.childmatkas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Список БрендМаток', ['route' => 'app.proekts.pasekas.matkas'])
            ->setExtra('routes', [
//                ['route' => 'app.proekts.page_glavas.brendmatka'],
                ['route' => 'app.proekts.pasekas.matkas'],
//                ['pattern' => '/^app.proekts.page_glavas.brendmatka\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

//        $menu
//            ->addChild('Раса', ['route' => 'app.proekts.pasekas.rasas.plemmatka'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.rasas'],
//                ['pattern' => '/^app.proekts.pasekas.rasas\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');

        // $menu
        //     ->addChild('Родословная', ['route' => 'app.proekts.drevorods.drerasa'])
        //     ->setExtra('routes', [
        //         ['route' => 'app.proekts.drevorods'],
        //         ['pattern' => '/^app.proekts.drevorods\..+/']
        //     ])
        //     ->setAttribute('class', 'nav_pro-item ')
        //     ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Участие', ['route' => 'app.proekts.pasekas.uchasties.uchastiee'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.uchastiee'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.uchastiee\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Список участников', ['route' => 'app.proekts.pasekas.uchasties.spisok'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.spisok'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.spisok\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');
//
//        $menu
//            ->addChild('Группы', ['route' => 'app.proekts.pasekas.uchasties.groupas'])
//            ->setExtra('routes', [
//                ['route' => 'app.proekts.pasekas.uchasties.groupas'],
//                ['pattern' => '/^app.proekts.pasekas.uchasties.groupas\..+/']
//            ])
//            ->setAttribute('class', 'nav_pro-item ')
//            ->setLinkAttribute('class', 'nav_pro-link ');

        return $menu;
    }

}