<?php

namespace App\Controller;

use App\Service\Interfaces\PlateauServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlateauController extends AbstractController
{
    private $plateauService;

    public function __construct(PlateauServiceInterface $plateauService)
    {
        $this->plateauService = $plateauService;
    }

    /**
     * @Route("/plateau/create", name="create_plateau", methods={"POST"})
     */
    public function createPlateau(Request $request): JsonResponse
    {
        $height = $request->query->get('height', 0);
        $width = $request->query->get('width', 0);

        $plateau = $this->plateauService->createPlateau($width, $height);

        return new JsonResponse($plateau);
    }

    /**
     * @Route("/plateau/get", name="get_plateau", methods={"GET"})
     */
    public function getPlateau(Request $request): JsonResponse
    {
        $plateauId = $request->query->get('id', 0);
        $plateau = $this->plateauService->getPlateau((int)$plateauId);

        return new JsonResponse($plateau);
    }
}
