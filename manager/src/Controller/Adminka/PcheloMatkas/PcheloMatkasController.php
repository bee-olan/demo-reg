<?php

declare(strict_types=1);

namespace App\Controller\Adminka\PcheloMatkas;

//use App\Annotation\Guid;

use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
//use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\Id;

use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Remove;
use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\Filter;

use App\ReadModel\Adminka\PcheloMatkas\PcheloMatka\PcheloMatkaFetcher;
use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/pchelomatkas", name="adminka.pchelomatkas")
 */
class PcheloMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PcheloMatkaFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PcheloMatkaFetcher $fetcher): Response
    {
//        $filter = new Filter\Filter();

//        if ($this->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $filter = Filter\Filter::allPagin();
//        } else {
//            $filter = Filter\Filter::forUchastie($this->getUser()->getId());
//        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

//        $pagination = $fetcher->allPagin(
//            $filter,
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort', 'name', 'status'),
//            $request->query->get('direction', 'asc')
//        );

        return $this->render('app/adminka/pchelomatkas/index.html.twig', [
//            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PcheloMatka $pchelomatka, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.pchelomatkas');
        }

        $command = new Remove\Command($pchelomatka->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('adminka.pchelomatkas');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.pchelomatkas');
    }

}