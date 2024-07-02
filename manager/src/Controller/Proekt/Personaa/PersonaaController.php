<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Personaa;

use App\Controller\ErrorHandler;
use App\Model\User\Entity\User\User;
use App\ReadModel\User\UserFetcher;

use App\Model\Adminka\UseCase\Uchasties\Personas\Create;

use App\Model\Adminka\UseCase\Uchasties\Personas\Diapazon;

use App\ReadModel\Adminka\Uchasties\PersonaFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/personaa", name="app.proekts.personaa")
 */
class PersonaaController extends AbstractController

{
    private $errors;
    private $users;

    public function __construct(ErrorHandler $errors, UserFetcher $users)
    {
        $this->errors = $errors;
        $this->users = $users;
    }
    /**
     * @Route("/diapazon", name=".diapazon")
     * @param PersonaFetcher $fetcher
     * @param Diapazon\Handler $handler
     * @return Response
     */
    public function diapazon( PersonaFetcher $fetcher, Request $request, Diapazon\Handler $handler ): Response
    {
        $diapazon = 1;

        if ($fetcher->exists($this->getUser()->getId() )) {
            $this->addFlash('error', 'Вы уже выбрали ПЕРСОНАЬНЫЙ номер .');
            return $this->redirectToRoute('app.proekts.personaa.inform');
        }
        $personas = $fetcher->allPers();
       /// dd($personas);
        $command = new Diapazon\Command();

        $form = $this->createForm(Diapazon\Form::class, $command);

        $form->handleRequest($request);

        $diapazon = $command->diapazon;

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $handler->handle($command);

                return $this->redirectToRoute('app.proekts.personaa',  ['itogo' => $diapazon]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/personaa/diapazon.html.twig', [
            'form' => $form->createView(),
            'personas' => $personas,
        ]);
    }

//    /**
//     * @Route("/show", name=".show")
//     * @param PersonaFetcher $fetchers
//     * @param PersonaRepository $personas
//     * @return Response
//     */
//    public function show(PersonaFetcher $fetchers, PersonaRepository $personas,
//                         Request $request ): Response
//    {
//        $fetcher = $fetchers->allPers();
//
//        $persona = $personas ->get(new Id($this->getUser()->getId()));
//
//
//        return $this->render('app/proekts/personaa/show.html.twig',
//            compact('fetcher', 'persona'));
//
//    }

    /**
     * @Route("/{itogo}", name="")
     * @param PersonaFetcher $fetcher
     * @param int $itogo
     * @return Response
     */
    public function index(int $itogo, PersonaFetcher $fetcher): Response
    {

//
        //$personas = $fetcher->all();
		$personas = $fetcher->all();
		//dd($personas[]['nomer']);
        $i = 0;
        $kol_nomer = 50;
        $resul =[];
       // dd($personas);
		foreach($personas as $row) {
		$i++;
		$resul[$i]=$row['nomer'];
		}

        $kol_na4 =  $kol_nomer* ($itogo-1) + 1;
        $kol_kon =  $kol_nomer* $itogo + 1;
		$pe = [];
        for ( $i = $kol_na4; $i < $kol_kon; $i++ )
            { $pe[$i]=$i; }
       // dd($pe);
		$persons = array_diff($pe,$resul);
//dd($persons);

      //  'personas', 'persons',
        return $this->render('app/proekts/personaa/index.html.twig',
				compact(  'personas', 'persons','itogo'));
    }

    /**
     * @Route("/{person}{itogo}/create", name=".create")
//	 * @param User $user
     * @param PersonaFetcher $personas
     * @param int $person
     * @param int $itogo
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( int $person, int $itogo, Request $request, PersonaFetcher $personas, Create\Handler $handler): Response
    {

        //dd($this->getUser()->getId());

        if ($personas->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'ПЕРСОНАЬНЫЙ номер уже существует..');
            return $this->redirectToRoute('app.proekts.personaa.inform', ['person' => $person]);
        }


		$command = new Create\Command($this->getUser()->getId() );
        $command->nomer = $person;

        //dd( $person);
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.personaa.inform');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/personaa/create.html.twig', [
            'form' => $form->createView(),
            'person' => $person,
            'itogo' =>  $itogo,
        ]);
    }




//     /**
//     * @Route("/{id}/delete", name=".delete", methods={"POST"})
//     * @param Persona $persona
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(Persona $persona, Request $request, Remove\Handler $handler): Response
    //{
    //     if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
    //         return $this->redirectToRoute('work.members.groups.show', ['id' => $persona->getId()]);
    //     }

    //     $command = new Remove\Command($persona->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //         return $this->redirectToRoute('work.members.groups');
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('work.members.groups.show', ['id' => $group->getId()]);
   // }
}
