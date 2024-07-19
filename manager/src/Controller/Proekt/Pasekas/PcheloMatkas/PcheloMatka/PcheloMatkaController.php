<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\PcheloMatka;

use App\Annotation\Guid;
//
//use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
//use App\Model\Adminka\Entity\Matkas\PcheloMatka\PlemMatka;
//
//use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id;
//use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\NomerRepository as OtNomerRepository;
//use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
//use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\PcheloMatkaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/app/proekts/pasekas/pchelomatkas/pchelomatka", name="app.proekts.pasekas.pchelomatkas.pchelomatka")
 */
class PcheloMatkaController extends AbstractController
{

   /**
    * @Route("/{pchelomatka_id}", name=".show", requirements={"pchelomatka_id"=Guid::PATTERN})
    * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
    * @param PcheloMatka $pchelomatka
    * @param PcheloMatkaFetcher $fetchers
    * @return Response
    */
   public function show(  PcheloMatka $pchelomatka,
//                            KategoriaFetcher $kategoria,
                            PcheloMatkaFetcher $fetchers

                        ): Response
   {
       $session = new Session();
       $sesMessages  = $session->getFlashBag()->get('notice', []);


//        $kategorias = $kategoria->all();
//        $permissions = Permission::names();
//
//        $infaMesto = $fetchers->infaMesto($pchelomatka->getMesto()->getNomer());
//
//        $nomer = $pchelomatka->getNomer();
//        $vetka = $nomer->getVetka();
//        $linia = $vetka->getLinia();
//        $rasa = $linia->getRasa();

       return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/show.html.twig',
           compact('pchelomatka'
//               'infaMesto',
//               'kategorias', 'permissions',
//                'sesMessages', 'otecNomer',
//           'rasa', 'linia', 'vetka', 'nomer'
           ));
   }
}
