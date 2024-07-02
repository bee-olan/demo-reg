<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekt/mestos/{raion_id}", name="app.proekts.mestos")
 * @ParamConverter("raion", options={"id" = "raion_id"})
 */
class MestoController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
//     * @Route("/mesto/{okrug_id},{oblast_id}", name=".mesto")
     * @Route("/mesto", name=".mesto")
     * @param Raion $raion
     * @return Response
     */
    public function mesto( Raion $raion): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);
        $oblast = $raion->getOblast()->getName();

        $okrug = $raion->getOblast()->getOkrug()->getName();
        return $this->render('app/proekts/mestos/mesto.html.twig', [
            'okrug' => $raion->getOblast()->getOkrug(),
            'oblast' => $raion->getOblast(),
            'raion' => $raion,
        ]);
    }
}
