<?php

declare(strict_types=1);

namespace App\Menu\Adminka;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DrevMainMenu
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
            ->addChild('Родословная', ['route' => 'drevos.rass'])
            ->setExtra(
                'routes',
                [
                    ['route' => 'drevos'],
                    ['pattern' => '/^drevos\..+/']
                ]
            )
            ->setAttribute('class', 'nav-item ')
            ->setLinkAttribute('class', 'nav-link ');

//        $menu
//            ->addChild('ЭлитМатки ', ['route' => 'adminka.elitmatkas'])
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');


//        if ($this->auth->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {


//        $menu
//            ->addChild('ДочьМатки - ???список', ['route' => 'adminka.elitmatkas.childmatkas'])
//            ->setExtra(
//                'routes',
//                [
//                    ['route' => 'adminka.matkas.childmatkas'],
//                    ['pattern' => '/^adminka.matkas.childmatkas\..+/']
//                ]
//            )
//            ->setAttribute('class', 'nav-item')
//            ->setLinkAttribute('class', 'nav-link');

        return $menu;
    }
}
