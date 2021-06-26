<?php

namespace App\Controller;

use App\Schema\Direction;
use App\Schema\Plateau;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use App\Service\RoverNavigatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoverController extends AbstractController
{
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
}
