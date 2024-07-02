<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Uchasties;

use App\Annotation\Guid;
//use App\Model\Paseka\Entity\Uchasties\Personas\Persona;
use App\Controller\ErrorHandler;
use App\Model\User\Entity\User\User;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;

use App\Model\Adminka\UseCase\Uchasties\Uchastie\Archive;
use App\Model\Adminka\UseCase\Uchasties\Uchastie\Edit;
use App\Model\Adminka\UseCase\Uchasties\Uchastie\Reinstate;
use App\Model\Adminka\UseCase\Uchasties\Uchastie\Create;
use App\Model\Adminka\UseCase\Uchasties\Uchastie\Move;
//use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
//use App\ReadModel\Adminka\ElitMatkas\PeriodFetcher;
//use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\Filter;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/uchasties", name="adminka.uchasties")
 */
class UchastiesController extends AbstractController
{
    private const PER_PAGE = 10;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'nike'),
            $request->query->get('direction', 'asc')
        );
//dd($pagination);
        return $this->render('app/adminka/uchasties/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{id}", name=".create")
     * @param User $user
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(User $user, Request $request, UchastieFetcher $uchasties, Create\Handler $handler): Response
    {
        //dd($user);

//        if (!$uchasties->existsPerson($user->getId()->getValue())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('adminka.uchasties.personas.diapazon', ['id' => $user->getId()]);
//        }

        if ($uchasties->exists($user->getId()->getValue())) {
            $this->addFlash('error', 'участие  уже существует..');
            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        }
// следующие присваения перенести в Handler не можeм т.к. инфа  из $user
        $command = new Create\Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.uchasties.show', ['id' => $user->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/uchasties/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Uchastie $uchastie, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromUchastie($uchastie);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/uchasties/edit.html.twig', [
            'uchastie' => $uchastie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/move", name=".move")
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Move\Handler $handler
     * @return Response
     */
    public function move(Uchastie $uchastie, Request $request, Move\Handler $handler): Response
    {
        $command = Move\Command::fromUchastie($uchastie);

        $form = $this->createForm(Move\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/uchasties/move.html.twig', [
            'uchastie' => $uchastie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/archive", name=".archive", methods={"POST"})
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(Uchastie $uchastie, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
        }

        $command = new Archive\Command($uchastie->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
    }

    /**
     * @Route("/{id}/reinstate", name=".reinstate", methods={"POST"})
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate(Uchastie $uchastie, Request $request, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
        }

        if ($uchastie->getId()->getValue() === $this->getUser()->getId()) {
            $this->addFlash('error', 'Не в состоянии восстановить себя.');
            return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
        }

        $command = new Reinstate\Command($uchastie->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.uchasties.show', ['id' => $uchastie->getId()]);
    }

//    /**
//     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
//     * @param Uchastie $uchastie
//     * @param DepartmentFetcher $fetcher
//     * @return Response
//     */
//    public function show(Uchastie $uchastie,  DepartmentFetcher $fetcher): Response
//    {
//        $departments = $fetcher->allOfUchastie($uchastie->getId()->getValue());
//
//        return $this->render('app/adminka/uchasties/show.html.twig',
//            compact('uchastie' , 'departments'));
//    }
//
//    /**
//     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
//     * @param Uchastie $uchastie
//     * @param PeriodFetcher $fetcher
//     * @return Response
//     */
//    public function showElit(Uchastie $uchastie, PeriodFetcher $fetcher): Response
//    {
//        $periods = $fetcher->allOfSostav($uchastie->getId()->getValue());
//        return $this->render('app/adminka/uchasties/showElit.html.twig',
//            compact('uchastie', 'periods'));
//    }
}
