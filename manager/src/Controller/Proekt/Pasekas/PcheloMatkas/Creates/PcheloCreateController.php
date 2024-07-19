<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Creates;

use App\Annotation\Guid;

use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Create;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\ReadModel\Adminka\PcheloMatkas\KategoriaFetcher;
use App\Model\Adminka\Entity\PcheloMatkas\Kategoria\Permission;
use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\PcheloMatkaFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/pchelomatkas/pchelomatka/creates", name="app.proekts.pasekas.pchelomatkas.pchelomatka.creates")
 */
class PcheloCreateController extends AbstractController
{

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/", name="")
     * @param Request $request
     * @param PcheloMatkaFetcher $pchelomatkas
     * @param UchastieFetcher $uchasties ,
     * @return Response
     */
    public function index(Request $request,
                          PcheloMatkaFetcher $pchelomatkas,
                          UchastieFetcher $uchasties
    ): Response
    {

        // $uchastie = $uchasties->find($this->getUser()->getId());

        if (!$uchasties->find($this->getUser()->getId())) {

            $this->addFlash('error', 'Внимание!!! Пожалуйста, начните с этого! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }

        return $this->render('app/proekts/pasekas/pchelomatkas/creates/index.html.twig'
        );
    }
//, requirements={"id"=Guid::PATTERN}

    /**
     * @Route("/{id}/pchelomatka/", name=".pchelomatka" )
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestos
     * @return Response
     */
    public function pchelomatka(Request $request,
                                UchastieFetcher $uchasties,
                                PersonaFetcher $personas,
                                MestoNomerFetcher $mestos
    ): Response
    {

        if (!$uchasties->find($this->getUser()->getId())) {
            $this->addFlash('error', 'Внимание!!! Для продолжения нужно стать участником проекта! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }

//        $newLinia = $nomer->getNewLinia();
//        $persona = $personas->find($this->getUser()->getId());
//
//        $mesto = $mestos->find($this->getUser()->getId());
//
//        $vetka = $nomer->getVetka();
//        $linia = $vetka->getLinia();
//        $rasa = $linia->getRasa();

        return $this->render('app/proekts/pasekas/pchelomatkas/creates/pchelomatka.html.twig',
            compact());
    }

    /**
     * @Route("/create", name=".create" )
     * @param Request $request
     * @param PcheloMatkaFetcher $pchelomatkas
     * @param UchastieFetcher $uchasties
     * @param KategoriaFetcher $kategoria
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request,
                           PcheloMatkaFetcher $pchelomatkas,
                           UchastieFetcher $uchasties,
                           KategoriaFetcher $kategoria,
                           Create\Handler $handler): Response
    {
        if (!$uchasties->find($this->getUser()->getId())) {
            $this->addFlash('error', 'Внимание!!! Пожалуйста, начните с этого! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        } else {
            if (!$pchelomatkas->existsPerson($this->getUser()->getId())) {
                $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
                return $this->redirectToRoute('app.proekts.personaa.diapazon');
            }

            if (!$pchelomatkas->existsMesto($this->getUser()->getId())) {
                $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
                return $this->redirectToRoute('app.proekts.mestos.okrugs');
            }

        }

        $kategorias = $kategoria->all();
        $permissions = Permission::names();
//dd($nomer);
        $sort = $pchelomatkas->getMaxSort() + 1;
//        dd( $sort);
        $command = new Create\Command($this->getUser()->getId(), $sort);

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
//                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.spisoks');
                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.creates.sdelano', ['title' => $command->title]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/creates/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
            'kategorias' => $kategorias,
            'permissions' => $permissions,
        ]);
    }

    /**
     * @Route("/{title}/sdelano", name=".sdelano" )
     * @ParamConverter("title", options={"id" = "title"})
     * @param Request $request
     * @param PcheloMatka $pchelomatka
     * //     * @param string $title
     * //     * @param MestoNomerFetcher $mestoNomers
     * //     * @param PcheloMatkaFetcher $pchelomatkas
     * @return Response
     */
    public function sdelano(PcheloMatka $pchelomatka,
                            Request $request): Response
//                             MestoNomerFetcher $mestoNomers,
//                            PcheloMatkaFetcher $pchelomatka
    {


        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/creates/sdelano.html.twig',
            [
                'pchelomatka' => $pchelomatka,
//                'nomerOtec' => $nomerOtec,
//                'rasa' => $pchelomatka->getNomer()->getVetka()->getLinia()->getRasa(),
//                'newLinia' => $newLinia,
//                'nomer' => $nomer,
            ]);
    }


    /**
     * @Route("/{pchelomatka_id}", name=".show", requirements={"pchelomatka_id"=Guid::PATTERN})
     * @param PcheloMatka $pchelomatka
     * @param PcheloMatkaFetcher $fetchers
     * @return Response
     */
    public function show(PcheloMatkaFetcher $fetchers,
                         PcheloMatka $pchelomatka
    ): Response
    {

        // $pchelomatka = $fetchers->find($plem_id);
        // dd( $pchelomatka);


        return $this->render('app/proekts/pasekas/pchelomatkas/redaktorss/show.html.twig',
            compact('pchelomatka'
            ));
    }


}
