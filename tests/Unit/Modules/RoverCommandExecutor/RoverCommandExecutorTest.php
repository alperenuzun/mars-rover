<?php

namespace Unit\Modules\RoverCommandExecutor;

use App\Modules\RoverCommandExecutor\Parameters\RoverParameters;
use App\Modules\RoverCommandExecutor\RoverCommandExecutor;
use App\Modules\RoverCommandExecutor\RoverCommandExecutorManager;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoverCommandExecutorTest
 * @package Unit\Modules\RoverCommandExecutor
 * @coversDefaultClass \App\Modules\RoverCommandExecutor\RoverCommandExecutor
 */
class RoverCommandExecutorTest extends TestCase
{
    private $roverCommandExecutor;

    private $roverParameters;

    public function setUp(): void
    {
        $this->prepareParameters();

        $roverCommandExecutorManager = $this->createMock(RoverCommandExecutorManager::class);
        $roverCommandExecutorManager->method('execute')->willReturn($this->roverParameters);

        $this->roverCommandExecutor = new RoverCommandExecutor($roverCommandExecutorManager);
    }

    /**
     * @covers ::executeCommand
     */
    public function testItShouldHandleExecutionOfCommand()
    {
        $request = new ParameterBag(['commands' => 'LMLMLMLMM']);
        $result = $this->roverCommandExecutor->executeCommand($request);

        $this->assertEquals($this->roverParameters->getRovers(), $result);
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
