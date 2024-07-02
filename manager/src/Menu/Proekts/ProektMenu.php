<?php

declare(strict_types=1);

namespace App\Menu\Proekts;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProektMenu
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
            ->addChild('Главная', ['route' => 'proekt'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'proekt'],
//                    ['route' => 'app.proekts.basepro'],
//                    ['pattern' => '/^proekt\..+/'],
//                    ['pattern' => '/^app.proekts.basepro\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link nav_pro-link--glav');


        $menu
            ->addChild('Элит-Матки', ['route' => 'app.proekts.page_glavas.elitmatka.show'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.elitmatka.show'],
//                    ['route' => 'app.proekts.drevorods.rodras'],
//                    ['route' => 'app.proekts.pasekas.elitmatkas.spisoks'],
//                    ['route' => 'app.proekts.pasekas.elitmatkas.elitcreates'],
//
//                    ['pattern' => '/^app.proekts.pasekas.elitmatkas.elitmatka\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Дочь-Элит', ['route' => 'app.proekts.page_glavas.elitmatka.childs.show'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.elitmatka.childs.show'],
//                    ['route' => 'app.proekts.page_glavas.elitmatka.childs'],
//                    ['route' => 'app.proekts.pasekas.childelits'],
//                    ['pattern' => '/^app.proekts.page_glavas.elitmatka.childs\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Участие', ['route' => 'app.proekts.page_glavas.uchastieGl'])
            ->setExtra(
                'routes',
                [
//                    ['route' => 'app.proekts.page_glavas.uchastieGl'],
//                    ['route' => 'app.proekts.pasekas.uchasties.uchastiee'],
//                    ['route' => 'app.proekts.pasekas.uchasties.spisok'],
//                    ['route' => 'app.proekts.pasekas.uchasties.groupas'],
//                    ['route' => 'app.proekts.personaa'],
                    ['route' => 'app.proekts.mestos'],
//                    ['pattern' => '/^app.proekts.page_glavas.uchastieGl\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.uchasties.uchastiee\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.uchasties.spisok\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.uchasties.groupas\..+/'],
//                    ['pattern' => '/^app.proekts.personaa\..+/'],
                    ['pattern' => '/^app.proekts.mestos\..+/']
                ]
            )
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link nav_pro-link--glav');

        $menu
            ->addChild('Бренд-Матки', ['route' => 'app.proekts.page_glavas.brendmatka.show'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.brendmatka.show'],
//                    ['route' => 'app.proekts.drevorods.rasbrs'],
//                    ['route' => 'app.proekts.pasekas.otec_brend.ot_rasas'],
//                    ['route' => 'app.proekts.pasekas.otec_brend.kategor.kategor'],
//                    ['route' => 'app.proekts.pasekas.matkas.plemmatkas.creates'],
//                    ['route' => 'app.proekts.pasekas.matkas'],
//                    ['route' => 'app.proekts.pasekas.matkas.plemmatkas.redaktorss'],
//                    ['pattern' => '/^app.proekts.pasekas.matkas.plemmatkas.creates\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.otec_brend.kategor.kategor\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.matkas.plemmatkas\..+/'],
//                    ['pattern' => '/^app.proekts.pasekas.otec_brend.ot_rasas\..+/'],
//                    ['pattern' => '/^app.proekts.drevorods.rasbrs\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Дочь-Бренд', ['route' => 'app.proekts.page_glavas.brendmatka.childs.show'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.brendmatka.childs'],
//                    ['route' => 'app.proekts.pasekas.childmatkas'],
//                    ['route' => 'app.proekts.pasekas.matkas.plemmatkas.childmatka'],
//                    ['pattern' => '/^app.proekts.page_glavas.brendmatka.childs\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        $menu
            ->addChild('Пасека')
//            ->addChild('Пасека', ['route' => 'adminka.sezons.godas.ind-pr'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.pasekas'],
//                    ['route' => 'adminka.sezons'],
//                    ['route' => 'adminka.sezons.godas.mygoda'],
//                    ['route' => 'app.adminka.sezons.tochkas'],
//                    ['pattern' => '/^adminka.sezons.godas.mygoda\..+/'],
//                    ['pattern' => '/^adminka.sezons\..+/'],
//                    ['pattern' => '/^app.proekts.page_glavas.pasekas\..+/']
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link nav_pro-link--glav');

        $menu
            ->addChild('Пчело-Матки', ['route' => 'app.proekts.page_glavas.pchelomatka.show'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'app.proekts.page_glavas.pchelomatka.show'],
//                    ['route' => 'app.proekts.pasekas.pchelomatkas.pchelomatka.creates.create'],
//                    ['route' => 'app.proekts.pasekas.pchelomatkas.spisoks'],
//                    ['route' => 'app.proekts.pasekas.pchelomatkas.kategoris.kategor'],
//
//                ]
//            )
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Дочь-Пчело', ['route' => 'app.proekts.page_glavas.pchelomatka.childs.show'])
            ->setExtra(
                'routes',
                [
                    ['route' => 'app.proekts.page_glavas.pchelomatka.childs'],
                    ['pattern' => '/^app.proekts.page_glavas.pchelomatka.childs\..+/']
                ]
            )
            ->setAttribute('class', 'nav_pro-item ')
            ->setLinkAttribute('class', 'nav_pro-link ');

        return $menu;
    }

}