<?php

namespace App\Controller;

use App\Helper\RequestBodyResolver;
use App\Modules\RoverCommandExecutor\RoverCommandExecutor;
use App\Schema\RoverResult;
use App\Schema\RoverState;
use App\Service\Interfaces\RoverServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoverController extends AbstractController
{
    /** @var RoverServiceInterface */
    private $roverService;

    /** @var RoverCommandExecutor */
    private $roverCommandExecutor;

    public function __construct(RoverServiceInterface $roverService, RoverCommandExecutor $roverCommandExecutor)
    {
        $this->roverService = $roverService;
        $this->roverCommandExecutor = $roverCommandExecutor;
    }

    /**
     * @Route("/rover/execute-command/", name="rover_execute_command", methods={"POST"})
     *
     * @SWG\Tag(name="Send Command")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Crete Plateau",
     *     @SWG\Schema(
     *         type="object",
     *         required={"commands"},
     *         @SWG\Property(
     *             property="commands",
     *             type="string",
     *             description="commands for the rovers",
     *             example="LMLMLMLMM",
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the info about each rover's state",
     *     @Model(type="\App\Schema\RoverResult", groups={"exposed_data"})
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Returns the error message when faced with an error",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="message",
     *             type="string",
     *             description="Error message",
     *             example="Please give a valid body!",
     *         )
     *     )
     * )
     */
    public function executeCommand(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $rovers = $this->roverCommandExecutor->executeCommand($parameters);
        $roverResult = new RoverResult($rovers);

        return new JsonResponse($roverResult);
    }

    /**
     * @Route("/rover/create", name="create_rover", methods={"POST"})
     *
     * @SWG\Tag(name="Create Rover")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Crete Plateau",
     *     @SWG\Schema(
     *         type="object",
     *         required={"plateau_id", "x", "y", "heading"},
     *         @SWG\Property(
     *             property="plateau_id",
     *             type="integer",
     *             description="Plateau ID",
     *             example=1,
     *         ),
     *         @SWG\Property(
     *             property="x",
     *             type="integer",
     *             description="x coordinate for the rover",
     *             example=1,
     *         ),
     *         @SWG\Property(
     *             property="y",
     *             type="integer",
     *             description="y coordinate for the rover",
     *             example=2,
     *         ),
     *         @SWG\Property(
     *             property="heading",
     *             type="integer",
     *             description="heading for the rover",
     *             example="N",
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the info about the created rover",
     *     @Model(type="\App\Schema\Rover", groups={"exposed_data"})
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Returns the error message when faced with an error",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="message",
     *             type="string",
     *             description="Error message",
     *             example="Please give a valid body!",
     *         )
     *     )
     * )
     */
    public function createRover(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $plateauId = $parameters->get('plateau_id');
        $positionX = $parameters->get('x');
        $positionY = $parameters->get('y');
        $direction = $parameters->get('heading');

        $plateau = $this->roverService->createRover($plateauId, $positionX, $positionY, $direction);

        return new JsonResponse($plateau);
    }

    /**
     * @Route("/rover/get", name="get_rover", methods={"POST"})
     *
     * @SWG\Tag(name="Get Rover")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Get Rover",
     *     @SWG\Schema(
     *         type="object",
     *         required={"id"},
     *         @SWG\Property(
     *             property="id",
     *             type="integer",
     *             description="ID for the rover",
     *             example=1,
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the info about the requested rover",
     *     @Model(type="\App\Schema\Rover", groups={"exposed_data"})
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Returns the error message when faced with an error",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="message",
     *             type="string",
     *             description="Error message",
     *             example="Please give a valid body!",
     *         )
     *     )
     * )
     */
    public function getRover(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $roverId = $parameters->get('id', 0);
        $rover = $this->roverService->getRover((int)$roverId);

        return new JsonResponse($rover);
    }

    /**
     * @Route("/rover/get-state", name="get_rover_state", methods={"POST"})
     *
     * @SWG\Tag(name="Get Rover State")
     *
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     required=true,
     *     description="Request body for the Get Rover",
     *     @SWG\Schema(
     *         type="object",
     *         required={"id"},
     *         @SWG\Property(
     *             property="id",
     *             type="integer",
     *             description="ID for the rover",
     *             example=1,
     *         )
     *     )
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the state info about the requested rover",
     *     @Model(type="\App\Schema\RoverState", groups={"exposed_data"})
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Returns the error message when faced with an error",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="message",
     *             type="string",
     *             description="Error message",
     *             example="Please give a valid body!",
     *         )
     *     )
     * )
     *
     */
    public function getRoverState(Request $request): JsonResponse
    {
        $parameters = RequestBodyResolver::resolve($request);
        $roverId = $parameters->get('id', 0);
        $rover = $this->roverService->getRover((int)$roverId);

        return new JsonResponse(new RoverState((string)$rover));
    }
}
