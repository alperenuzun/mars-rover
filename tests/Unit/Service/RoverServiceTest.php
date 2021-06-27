<?php

namespace Unit\Service;

use App\Builder\RoverBuilder;
use App\Entity\Plateau;
use App\Entity\Rover;
use App\Repository\Interfaces\PlateauRepositoryInterface;
use App\Repository\Interfaces\RoverRepositoryInterface;
use App\Schema\Direction;
use App\Service\RoverService;
use PHPUnit\Framework\TestCase;

/**
 * Class RoverServiceTest
 * @package App\Tests\Unit\Service
 * @coversDefaultClass \App\Service\RoverService
 */
class RoverServiceTest extends TestCase
{
    private $roverService;

    private $roverEntity;
    private $plateauEntity;

    public function setUp(): void
    {
        $this->prepareParameters();

        $roverRepository = $this->createMock(RoverRepositoryInterface::class);
        $roverRepository->method('getRover')->willReturn($this->roverEntity);
        $roverRepository->method('getAllRovers')->willReturn([$this->roverEntity]);

        $plateauRepository = $this->createMock(PlateauRepositoryInterface::class);
        $plateauRepository->method('getPlateau')->willReturn($this->plateauEntity);

        $this->roverService = new RoverService($roverRepository, $plateauRepository);
    }

    /**
     * @covers ::getRover
     */
    public function testItShouldHandleGetRover()
    {
        $roverId = 1;
        $expected = RoverBuilder::createSchemaFromEntity($this->roverEntity);
        $rover = $this->roverService->getRover($roverId);

        $this->assertEquals($expected, $rover);
    }

    /**
     * @covers ::createRover
     */
    public function testItShouldHandleCreateRover()
    {
        $plateauId = 1;
        $positionX = 1;
        $positionY = 2;
        $direction = Direction::NORTH;

        $expected = RoverBuilder::createSchemaFromEntity($this->roverEntity);
        $rover = $this->roverService->createRover($plateauId, $positionX, $positionY, $direction);

        $this->assertEquals($expected, $rover);
    }

    /**
     * @covers ::getAllRovers
     */
    public function testItShouldHandleGetAllRovers()
    {
        $expected = [$this->roverEntity];
        $rovers = $this->roverService->getAllRovers();

        $this->assertEquals($expected, $rovers);
    }

    /**
     * @covers ::flushRovers
     */
    public function testItShouldHandleFlushRovers()
    {
        $this->expectNotToPerformAssertions();
        $this->roverService->flushRovers();
    }

    public function prepareParameters()
    {
        $this->roverEntity = (new Rover())
            ->setPositionX(1)
            ->setPositionY(2)
            ->setDirection(Direction::NORTH);

        $this->plateauEntity = (new Plateau())
            ->setWidth(5)
            ->setHeight(5);
    }
}
