<?php

declare(strict_types=1);

namespace App\Menu\Proekts\PageGlavas\Pasekas;

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
            ->addChild('Пасека', ['route' => 'app.proekts.page_glavas.pasekas'])
            ->setExtra('routes', [
                ['route' => 'app.proekts.page_glavas.pasekas'],
                ['pattern' => '/^app.proekts.page_glavas.pasekas\..+/'],
//                ['pattern' => '/^app.proekts.personaa.create\..+/'],
//                ['pattern' => '/^app.proekts.mestos.okrugs\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Выбрать Сезон', ['route' => 'adminka.sezons.godas.ind-pr'])
            ->setExtra('routes', [
                ['route' => 'adminka.sezons.godas'],
                ['route' => 'adminka.sezons.godas.ind-pr'],
                ['route' => 'adminka.sezons.godas.uchasgoda'],
                ['route' => 'app.adminka.sezons.tochkas'],
                ['pattern' => '/^adminka.sezons.godas.uchasgoda\..+/'],
                ['pattern' => '/^adminka.sezons.tochkas\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');

        $menu
            ->addChild('Мои сезоны', ['route' => 'adminka.sezons.godas.mygoda'])
            ->setExtra('routes', [
                ['route' => 'adminka.sezons.godas.mygoda'],
                ['pattern' => '/^adminka.sezons.godas.mygoda\..+/']
            ])
            ->setAttribute('class', 'nav_pro-item')
            ->setLinkAttribute('class', 'nav_pro-link');


        return $menu;
    }

}