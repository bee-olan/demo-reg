<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Kategoris;

//use App\Annotation\Guid;

use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Permission;

use App\ReadModel\Adminka\PcheloMatkas\KategoriaFetcher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/proekts/pasekas/pchelomatkas/kategoris/kategor", name="app.proekts.pasekas.pchelomatkas.kategoris.kategor")
 */
class KategorController extends AbstractController
{
 
    /**
     * @Route("/", name="")
     * @param Request $request
     * @param KategoriaFetcher $kategoria
     * @return Response
     */
    public function kategor( KategoriaFetcher $kategoria): Response
    {
        $kategorias = $kategoria->all();
       $permissions = Permission::names();

        return $this->render('/app/proekts/pasekas/pchelomatkas/kategoris/kategor.html.twig',
            compact('kategorias', 'permissions') );
    }

}