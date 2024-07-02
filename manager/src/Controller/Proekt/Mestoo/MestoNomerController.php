<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\Model\User\Entity\User\User;
use App\Model\Mesto\UseCase\InfaMesto\Create;

use App\Annotation\Guid;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/mestos", name="app.proekts.mestos")
 */
class MestoNomerController  extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/create/{raion_id},{mestonomer}", name=".create")
     * @param User $user
     * @param MestoNomerFetcher $fetcher
     * @param string  $raion_id
     * @param string  $mestonomer
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(string  $raion_id, string $mestonomer, Request $request, MestoNomerFetcher $fetcher, Create\Handler $handler): Response
    {

        if ($fetcher->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Ваш номер места расположения пасеки уже записан в БД');
            return $this->redirectToRoute('app.proekts.mestos.inform');
        }

        $command = new Create\Command($this->getUser()->getId() );

        $command = Create\Command::fromMesto($command, $raion_id, $mestonomer);

            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.mestos.inform');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }

        return $this->render('app/proekts/mestos/create.html.twig', [
            'mestonomer' => $mestonomer,
        ]);
    }

 

}