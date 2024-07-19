<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Redaktors;

use App\Annotation\Guid;

use  App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Edit;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Archive;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Reinstate;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\Model\Comment\UseCase\Comment;

use App\Controller\ErrorHandler;
use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\CommentPcheloFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktors", name="app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class RedaktorController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/show", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param PcheloMatka $pchelomatka
//     * @param CommentPcheloFetcher $comments
//     * @param Comment\AddSezon\Handler $commentHandler
     * @return Response
     */
    public function show(Request $request,
                         PcheloMatka $pchelomatka
//                         CommentPcheloFetcher $comments,
//                         Comment\AddSezon\Handler $commentHandler
    ): Response
    {

//        $commentCommand = new Comment\AddSezon\Command(
//            $this->getUser()->getId(),
//            PcheloMatka::class,
//            $pchelomatka->getId()->getValue()
//        );
//
//        $commentForm = $this->createForm(Comment\AddSezon\Form::class, $commentCommand);
//        $commentForm->handleRequest($request);
//        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
//            try {
//                $commentHandler->handle($commentCommand);
//                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/show.html.twig', [
            'pchelomatka' => $pchelomatka,
            'pchelovods' => $pchelomatka->getPchelovods()  ,
//            'comments' => $comments->allForPcheloMatka($pchelomatka->getId()->getValue()),
//            'commentForm' => $commentForm->createView(),

        ]);
    }

    /**
     * @Route("/edit", name=".edit")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(PcheloMatka $pchelomatka, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::EDIT, $pchelomatka);

        $command = Edit\Command::fromPcheloMatka($pchelomatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archive", name=".archive", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(PcheloMatka $pchelomatka, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['id' => $pchelomatka->getId()]);
        }

//         $this->denyAccessUnlessGranted(PcheloMatkaAccess::EDIT, pchelomatka);

        $command = new Archive\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    /**
     * @Route("/reinstate", name=".reinstate", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate(PcheloMatka $pchelomatka, Request $request, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::EDIT, $pchelomatka);

        $command = new Reinstate\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
    }


}