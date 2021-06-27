<?php

namespace App\Controller;

use App\Helper\RequestBodyResolver;
use App\Service\Interfaces\PlateauServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
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
     *
     * @SWG\Tag(name="Create Plateau")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Crete Plateau",
     *     @SWG\Schema(
     *         type="object",
     *         required={"height", "width"},
     *         @SWG\Property(
     *             property="width",
     *             type="integer",
     *             description="X parameter for the plateau",
     *             example=5,
     *         ),
     *         @SWG\Property(
     *             property="height",
     *             type="integer",
     *             description="Y parameter for the plateau",
     *             example=5,
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the info about the created plateau",
     *     @Model(type="\App\Schema\Plateau", groups={"exposed_data"})
     * )
     */
    public function createPlateau(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $height = $parameters->get('height', 0);
        $width = $parameters->get('width', 0);

        $plateau = $this->plateauService->createPlateau($width, $height);

        return new JsonResponse($plateau);
    }

    /**
     * @Route("/plateau/get", name="get_plateau", methods={"POST"})
     *
     * @SWG\Tag(name="Get Plateau")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Get Plateau",
     *     @SWG\Schema(
     *         type="object",
     *         required={"id"},
     *         @SWG\Property(
     *             property="id",
     *             type="integer",
     *             description="ID for the plateau",
     *             example=1,
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the info about the requested plateau",
     *     @Model(type="\App\Schema\Plateau", groups={"exposed_data"})
     * )
     */
    public function getPlateau(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $plateauId = $parameters->get('id', 0);
        $plateau = $this->plateauService->getPlateau((int)$plateauId);

        return new JsonResponse($plateau);
    }
}
