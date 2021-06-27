<?php

namespace Unit\Modules\RoverCommandExecutor\Handlers;

use App\Modules\RoverCommandExecutor\Handlers\CommandValidatorHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandValidatorHandlerTest
 * @package Unit\Modules\RoverCommandExecutor\Handlers
 * @coversDefaultClass \App\Modules\RoverCommandExecutor\Handlers\CommandValidatorHandler
 */
class CommandValidatorHandlerTest extends TestCase
{
    private $commandValidatorHandler;
    private $roverParameters;
    private $invalidRoverParameters;
    private $commands;

    public function setUp(): void
    {
        $this->prepareParameters();
        $this->commandValidatorHandler = new CommandValidatorHandler();
    }

    /**
     * @covers ::process
     */
    public function testItShouldProcessForCommandValidatorHandlerInRoverCommandExecutorChain()
    {
        $expected = str_split($this->commands);
        $result = $this->commandValidatorHandler->process($this->roverParameters);
        $this->assertEquals($expected, $result->getCommands());
    }

    /**
     * @covers ::process
     */
    public function testItShouldProcessForCommandValidatorHandlerInRoverCommandExecutorChainWhenInvalidCommandExists()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->commandValidatorHandler->process($this->invalidRoverParameters);
    }

    /**
     * @covers ::isProcessable
     */
    public function testItShouldIsProcessableForCommandValidatorHandlerInRoverCommandExecutorChain()
    {
        $this->assertTrue($this->commandValidatorHandler->isProcessable($this->roverParameters));
    }

    public function prepareParameters()
    {
        $this->commands = 'LMLMLMLMM';
        $invalidCommands = 'INVALIDCOMMAND';

        $roverSchema = new Rover(
            new Direction(Direction::NORTH),
            new Position(
                new Point(1),
                new Point(2)
            )
        );

        $this->roverParameters = (new RoverParameters())
            ->setRovers(new ArrayCollection([$roverSchema]))
            ->setRequestCommands($this->commands);

        $this->invalidRoverParameters = (new RoverParameters())
            ->setRovers(new ArrayCollection([$roverSchema]))
            ->setRequestCommands($invalidCommands);
    }
}
