<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Redaktors\PcheloSezon;

use App\Controller\ErrorHandler;

use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;


use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\Security\Voter\Comment\CommentAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas/pchelomatkas/redaktorss/{pchelomatka_id}/comment", name="app.proekts.pasekas.matkas.pchelomatkas.redaktorss.comment")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class CommentPcheloSezonController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param PcheloMatka $pchelomatka
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Comment $comment, PcheloMatka $pchelomatka, Edit\Handler $handler): Response
    {
//       dd($pchelomatka->getOblasts());
//        dd($oblast->getPcheloMatka()->getName());
//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForPlem($pchelomatka, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.matkas.pchelomatkas.redaktorss.show', ['pchelomatka_id' => $pchelomatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/matkas/pchelomatkas/redaktorss/comment/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
//            'oblast' => $pchelomatka->getOblasts(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PcheloMatka $pchelomatka, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.matkas.pchelomatkas.redaktorss.show', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForPlem($pchelomatka, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.matkas.pchelomatkas.redaktorss.show', ['pchelomatka_id' => $pchelomatka->getId()]);
    }

    private function checkCommentIsForPlem(PcheloMatka $pchelomatka, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === PcheloMatka::class &&
            $comment->getEntity()->getId() === $pchelomatka->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
