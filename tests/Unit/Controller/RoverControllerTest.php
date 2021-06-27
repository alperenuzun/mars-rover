<?php

namespace Unit\Controller;

use App\Controller\RoverController;
use App\Modules\RoverCommandExecutor\RoverCommandExecutor;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use App\Schema\RoverResult;
use App\Schema\RoverState;
use App\Service\Interfaces\RoverServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoverControllerTest
 * @package Unit\Controller
 * @coversDefaultClass \App\Controller\RoverController
 */
class RoverControllerTest extends TestCase
{
    private $roverController;
    private $roverSchema;

    public function setUp(): void
    {
        $this->prepareParameters();

        $roverService = $this->createMock(RoverServiceInterface::class);
        $roverService->method('createRover')->willReturn($this->roverSchema);
        $roverService->method('getRover')->willReturn($this->roverSchema);

        $roverCommandExecutor = $this->createMock(RoverCommandExecutor::class);
        $roverCommandExecutor->method('executeCommand')->willReturn(new ArrayCollection([$this->roverSchema]));

        $this->roverController = new RoverController($roverService, $roverCommandExecutor);
    }

    /**
     * @covers ::executeCommand
     */
    public function testItShouldHandleExecuteCommandEndpoint()
    {
        $request = new Request();
        $request->request->set('height', 5);
        $request->request->set('width', 5);

        $rover = $this->roverController->executeCommand($request);

        $this->assertEquals(
            new JsonResponse(new RoverResult(new ArrayCollection([$this->roverSchema]))),
            $rover
        );
    }

    /**
     * @covers ::createRover
     */
    public function testItShouldHandleCreateRoverEndpoint()
    {
        $request = new Request();
        $request->request->set('plateau_id', 1);
        $request->request->set('x', 1);
        $request->request->set('y', 2);
        $request->request->set('heading', Direction::NORTH);

        $rover = $this->roverController->createRover($request);

        $this->assertEquals(new JsonResponse($this->roverSchema), $rover);
    }

    /**
     * @covers ::getRover
     */
    public function testItShouldHandleGetRoverEndpoint()
    {
        $request = new Request();
        $request->request->set('id', 1);

        $rover = $this->roverController->getRover($request);

        $this->assertEquals(new JsonResponse($this->roverSchema), $rover);
    }

    /**
     * @covers ::getRoverState
     */
    public function testItShouldHandleGetRoverStateEndpoint()
    {
        $request = new Request();
        $request->request->set('id', 1);

        $rover = $this->roverController->getRoverState($request);

        $this->assertEquals(new JsonResponse(new RoverState((string)$this->roverSchema)), $rover);
    }

    public function prepareParameters()
    {
        $roverSchema = new Rover(
            new Direction(Direction::NORTH),
            new Position(
                new Point(1),
                new Point(2)
            )
        );
        $this->roverSchema = $roverSchema;
        $this->roverSchema = $roverSchema;
    }
}
