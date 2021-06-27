<?php

namespace App\Controller;

use App\Modules\RoverCommandExecutor\RoverCommandExecutor;
use App\Schema\RoverResult;
use App\Schema\RoverState;
use App\Service\Interfaces\RoverServiceInterface;
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
     */
    public function executeCommand(Request $request): JsonResponse
    {
        $rovers = $this->roverCommandExecutor->executeCommand($request);
        $roverResult = new RoverResult($rovers);

        return new JsonResponse($roverResult);
    }

    /**
     * @Route("/rover/create", name="create_rover", methods={"POST"})
     */
    public function createRover(Request $request): JsonResponse
    {
        $plateauId = $request->query->get('plateau_id');
        $positionX = $request->query->get('x');
        $positionY = $request->query->get('y');
        $direction = $request->query->get('heading');

        $plateau = $this->roverService->createRover($plateauId, $positionX, $positionY, $direction);

        return new JsonResponse($plateau);
    }

    /**
     * @Route("/rover/get", name="get_rover", methods={"GET"})
     */
    public function getRover(Request $request): JsonResponse
    {
        $roverId = $request->query->get('id', 0);
        $rover = $this->roverService->getRover((int)$roverId);

        return new JsonResponse($rover);
    }

    /**
     * @Route("/rover/get-state", name="get_rover_state", methods={"GET"})
     */
    public function getRoverState(Request $request): JsonResponse
    {
        $roverId = $request->query->get('id', 0);
        $rover = $this->roverService->getRover((int)$roverId);

        return new JsonResponse(new RoverState((string)$rover));
    }
}
