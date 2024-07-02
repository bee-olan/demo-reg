<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Uchasties\Uchastiee;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
//use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
//use App\Model\Adminka\UseCase\Uchasties\Uchastie\Create;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

//use App\Model\User\Entity\User\User;
//use App\Model\User\Entity\User\UserRepository;
//use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
//use App\ReadModel\User\UserFetcher;
//use Psr\Log\LoggerInterface;
use App\Controller\ErrorHandler;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/uchasties/uchastiee", name="app.proekts.pasekas.uchasties.uchastiee")
 */
class UchastieControllr extends AbstractController
{

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $uchasties,
                          PersonaFetcher $personas, MestoNomerFetcher $mestoNomers
                            ): Response
    {
        $idUser = $this->getUser()->getId();

        $persona = $personas->find($idUser);

        $mestoNomer = $mestoNomers->find($idUser);

        $uchastie = $uchasties->find($idUser);

        return $this->render('app/proekts/pasekas/uchasties/uchastiee/index.html.twig',
            compact('uchastie', 'persona', 'mestoNomer')
        );
    }

//    /**
//     * @Route("/create", name=".create")
//     * @param Request $request
//     * @param UserRepository $users
//     * @param PlemMatkaFetcher $plemmatkas
//     * @param Create\Handler $handler
//     * @return Response
//     */
//    public function create( Request $request,
//                    UserRepository $users,
//                    PlemMatkaFetcher $plemmatkas,
//                    Create\Handler $handler): Response
//    {
//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//
//            $this->addFlash('error', 'Внимание!!! Выбрать ПерсонНомер ');
//            return $this->redirectToRoute('app.proekts.personaa.diapazon');
//        }
//
//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            // dd($this->getUser()->getId());
//           $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//           return $this->redirectToRoute('app.proekts.mestoo.okrugs');
//       }
//
//
//        $idUser = $this->getUser()->getId();
////
//
//        $idUser = $this->getUser()->getId();
//        $user = $users->find($idUser);
////        dd($user);
//// следующие присваения перенести в Handler не можeм т.к. инфа  из $user
//        $command = new Create\Command($idUser);
//        $command->firstName = $user->getName()->getFirst();
//        $command->lastName = $user->getName()->getLast();
//        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;
//
//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/proekts/pasekas/uchasties/uchastiee/create.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/show/{id}", name=".show", requirements={"id"=Guid::PATTERN} )
     * @param UchastieRepository $uchasties
//     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function show(UchastieRepository $uchasties, string $id): Response
    {
        $uchastie = $uchasties->get(new Id($id));
        //$infaMesto = $fetchers->infaMesto($plemmatka->getMesto());
       // dd($uchastie);
        return $this->render('app/proekts/pasekas/uchasties/uchastiee/show.html.twig',
            compact('uchastie')
        );
    }

}