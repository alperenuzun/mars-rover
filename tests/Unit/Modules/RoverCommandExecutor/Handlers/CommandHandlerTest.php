<?php

namespace Unit\Modules\RoverCommandExecutor\Handlers;

use App\Modules\RoverCommandExecutor\Handlers\CommandHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use App\Service\Interfaces\RoverNavigatorServiceInterface;
use App\Service\Interfaces\RoverServiceInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandHandlerTest
 * @package Unit\Modules\RoverCommandExecutor\Handlers
 * @coversDefaultClass \App\Modules\RoverCommandExecutor\Handlers\CommandHandler
 */
class CommandHandlerTest extends TestCase
{
    private $commandHandler;
    private $roverParameters;
    private $roverEntity;
    private $roverSchema;

    public function setUp(): void
    {
        $this->prepareParameters();

        $roverService = $this->createMock(RoverServiceInterface::class);
        $roverService->method('getAllRovers')->willReturn([$this->roverEntity]);

        $roverNavigatorService = $this->createMock(RoverNavigatorServiceInterface::class);
        $roverNavigatorService->method('executeCommand')->willReturn($this->roverSchema);
        $roverNavigatorService->method('isOutOfTheBorder')->willReturn(false);

        $this->commandHandler = new CommandHandler($roverService, $roverNavigatorService);
    }

    /**
     * @covers ::process
     */
    public function testItShouldProcessForCommandHandlerInRoverCommandExecutorChain()
    {
        $result = $this->commandHandler->process($this->roverParameters);
        $this->assertEquals($this->roverSchema, $result->getRovers()->first());
    }

    /**
     * @covers ::isProcessable
     */
    public function testItShouldIsProcessableForCommandHandlerInRoverCommandExecutorChain()
    {
        $this->assertTrue($this->commandHandler->isProcessable($this->roverParameters));
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

        $movement = ['L', 'M', 'L', 'M', 'L', 'M', 'L', 'M', 'M'];

        $this->roverParameters = (new RoverParameters())
            ->setCommands($movement);

        $this->roverEntity = (new \App\Entity\Rover())
            ->setPositionX(1)
            ->setPositionY(2)
            ->setDirection(Direction::NORTH);
    }
}
