<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PcheloMatkas\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\PcheloMatkas\PcheloMatka\PcheloMatka;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\UseCase\PcheloMatkas\PcheloMatka\Pchelovod;

use App\Controller\ErrorHandler;
//use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/pchelomatkas/pchelomatka/{pchelomatka_id}/redaktors/pchelovods", name="app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.pchelovods")
 * @ParamConverter("pchelomatka", options={"id" = "pchelomatka_id"})
 */
class PchelovodsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function index(PcheloMatka $pchelomatka): Response
    {
//        $this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_UCHASTIES, $pchelomatka);
// выводит из проекта pchelovods - учстников
        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelovods/index.html.twig', [
            'pchelomatka' => $pchelomatka,
            'pchelovods' => $pchelomatka->getPchelovods(),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Pchelovod\Add\Handler $handler
     * @return Response
     */
    public function assign(PcheloMatka $pchelomatka, Request $request, Pchelovod\Add\Handler $handler): Response
    {

        if (!$pchelomatka->getPchelosezons() ) {
            $this->addFlash('error', 'Добавьте сезоны перед добавлением участников.');
            return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()]);
        }

        $command = new Pchelovod\Add\Command($pchelomatka->getId()->getValue());

            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.show', ['pchelomatka_id' => $pchelomatka->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelovods/assign.html.twig', [
            'pchelomatka' => $pchelomatka,
        ]);
    }

    /**
     * @Route("/edit", name=".edit")
     * @param PcheloMatka $pchelomatka
     * @param Request $request
     * @param Pchelovod\EditSez\Handler $handler
     * @return Response
     */
    public function edit( Request $request,
                        PcheloMatka $pchelomatka,
                        Pchelovod\EditSez\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(PcheloMatkaAccess::MANAGE_UCHASTIES, $pchelomatka);
        $pchelovodI = $pchelomatka->getPersona()->getId()->getValue();

        if ($pchelovodI ==! $this->getUser()->getId()) {
            $this->addFlash('error', 'Эту матку зарегистрировали не Вы.');
            return $this->redirectToRoute('app.proekts.pasekas.matkas');
        }

        $pchelovod = $pchelomatka->getPchelovod(new Id($pchelovodI));

        $command = Pchelovod\EditSez\Command::fromPchelovod($pchelomatka, $pchelovod);

        $form = $this->createForm(Pchelovod\EditSez\Form::class, $command, ['pchelomatka' => $pchelomatka->getId()->getValue()]);
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

        return $this->render('app/proekts/pasekas/pchelomatkas/pchelomatka/redaktors/pchelovods/edit.html.twig', [
            'pchelomatka' => $pchelomatka,
            'pchelovod' => $pchelovod,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
     * @param PcheloMatka $pchelomatka
     * @return Response
     */
    public function show(PcheloMatka $pchelomatka): Response
    {
        return $this->redirectToRoute('app.proekts.pasekas.pchelomatkas.pchelomatka.redaktors.pchelovods', ['pchelomatka_id' => $pchelomatka->getId()]);
    }
}
