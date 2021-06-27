<?php

namespace App\Controller;

use App\Schema\Direction;
use App\Schema\Plateau;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use App\Schema\RoverState;
use App\Service\Interfaces\RoverServiceInterface;
use App\Service\RoverNavigatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoverController extends AbstractController
{
    /** @var RoverServiceInterface */
    private $roverService;

    public function __construct(RoverServiceInterface $roverService)
    {
        $this->roverService = $roverService;
    }

    /**
     * @Route("/rover/execute-command/", name="rover_execute_command", methods={"GET"})
     */
    public function executeCommand(Request $request): JsonResponse
    {
        $commands = $request->query->get('commands');

        $plateau = new Plateau(new Position(new Point(5), new Point(5)));
        $rover = new Rover(new Direction(Direction::NORTH), new Position(new Point(1), new Point(2)));

        $navigatorService = new RoverNavigatorService($rover);
        $result = $navigatorService->executeCommand(str_split($commands));

        return new JsonResponse(['status' => true, 'result' => $result]);
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
