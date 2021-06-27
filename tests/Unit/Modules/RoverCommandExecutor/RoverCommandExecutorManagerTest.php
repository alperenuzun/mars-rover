<?php

namespace Unit\Modules\RoverCommandExecutor;

use App\Modules\RoverCommandExecutor\Handlers\CommandHandler;
use App\Modules\RoverCommandExecutor\Handlers\CommandValidatorHandler;
use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Modules\RoverCommandExecutor\RoverCommandExecutorManager;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class RoverCommandExecutorManagerTest
 * @package Unit\Modules\RoverCommandExecutor
 * @coversDefaultClass \App\Modules\RoverCommandExecutor\RoverCommandExecutorManager
 */
class RoverCommandExecutorManagerTest extends TestCase
{
    private $roverParameters;

    public function setUp(): void
    {
        $this->prepareParameters();
    }

    /**
     * @covers ::execute
     * @covers ::prepareHandlers
     */
    public function testItShouldRunCommandExecutorChain()
    {
        $roverCommandExecutorManager = $this->getRoverCommandExecutorManager();
        $roverCommandExecutorManager->execute($this->roverParameters);
    }

    /**
     * @covers ::execute
     */
    public function testItShouldRunCommandExecutorChainWhenInvalidCommandProvided()
    {
        $this->expectException(\InvalidArgumentException::class);
        $roverCommandExecutorManager = $this->getRoverCommandExecutorManagerForInvalidCommands();
        $roverCommandExecutorManager->execute($this->roverParameters);
    }

    public function getRoverCommandExecutorManager(): RoverCommandExecutorManager
    {
        $commandValidatorHandler = $this->getMockBuilder(CommandValidatorHandler::class)
            ->disableOriginalConstructor()->setMethods(['process'])->getMock();
        $commandValidatorHandler->expects($this->once())->method('process')->willReturn($this->roverParameters);

        $commandHandler = $this->getMockBuilder(CommandHandler::class)
            ->disableOriginalConstructor()->setMethods(['process'])->getMock();
        $commandHandler->expects($this->once())->method('process')->willReturn($this->roverParameters);

        $roverCommandExecutorManager = new RoverCommandExecutorManager($commandValidatorHandler, $commandHandler);
        $roverCommandExecutorManager->prepareHandlers();

        return $roverCommandExecutorManager;
    }

    public function getRoverCommandExecutorManagerForInvalidCommands(): RoverCommandExecutorManager
    {
        $commandValidatorHandler = $this->getMockBuilder(CommandValidatorHandler::class)
            ->disableOriginalConstructor()->setMethods(['process'])->getMock();
        $commandValidatorHandler->expects($this->once())->method('process')
            ->willThrowException(new \InvalidArgumentException('test'));

        $commandHandler = $this->getMockBuilder(CommandHandler::class)
            ->disableOriginalConstructor()->setMethods(['process'])->getMock();
        $commandHandler->expects($this->never())->method('process')->willReturn($this->roverParameters);

        $roverCommandExecutorManager = new RoverCommandExecutorManager($commandValidatorHandler, $commandHandler);
        $roverCommandExecutorManager->prepareHandlers();

        return $roverCommandExecutorManager;
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

        $this->roverParameters = (new RoverParameters())
            ->setRovers(new ArrayCollection([$roverSchema]));
    }
}
