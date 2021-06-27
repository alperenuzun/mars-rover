<?php

namespace Unit\Service;

use App\Entity\Plateau;
use App\Entity\Rover as RoverEntity;
use App\Schema\Direction;
use App\Schema\Point;
use App\Schema\Position;
use App\Schema\Rover;
use App\Service\RoverNavigatorService;
use PHPUnit\Framework\TestCase;

/**
 * Class RoverNavigatorServiceTest
 * @package App\Tests\Unit\Service
 * @coversDefaultClass \App\Service\RoverNavigatorService
 */
class RoverNavigatorServiceTest extends TestCase
{
    private $roverNavigatorService;

    public function setUp(): void
    {
        $this->roverNavigatorService = new RoverNavigatorService();
    }

    /**
     * @covers ::executeCommand
     * @dataProvider commandDataProvider
     *
     * @param $rover
     * @param $expected
     */
    public function testItShouldHandleCommandsWhenValidCommandsProvided($rover, $expected)
    {
        $movement = ['L', 'M', 'L', 'M', 'L', 'M', 'L', 'M', 'M'];

        $roverResult = $this->roverNavigatorService->executeCommand($movement, $rover);

        $this->assertEquals($expected, (string)$roverResult);
    }

    /**
     * @covers ::executeCommand
     * @dataProvider commandInvalidDataProvider
     *
     * @param $rover
     */
    public function testItShouldHandleExceptionWhenInValidCommands($rover)
    {
        $movement = ['M', 'S'];

        $this->expectException(\InvalidArgumentException::class);

        $this->roverNavigatorService->executeCommand($movement, $rover);
    }

    /**
     * @covers ::isOutOfTheBorder
     * @dataProvider OutOfTheBorderDataProvider
     */
    public function testItShouldReturnTrueWhenItIsOutOfTheBorders($roverSchema, $roverEntity, $expected)
    {
        $result = $this->roverNavigatorService->isOutOfTheBorder($roverSchema, $roverEntity);

        $this->assertEquals($expected, $result);
    }

    public function commandDataProvider(): array
    {
        $rover1 = new Rover(
            new Direction('N'),
            new Position(
                new Point(1),
                new Point(2)
            )
        );

        $rover2 = new Rover(
            new Direction('E'),
            new Position(
                new Point(0),
                new Point(2)
            )
        );

        return [
            [$rover1, '1 3 N'],
            [$rover2, '1 2 E']
        ];
    }

    public function commandInvalidDataProvider(): array
    {
        $rover = new Rover(
            new Direction('N'),
            new Position(
                new Point(1),
                new Point(2)
            )
        );

        return [
            [$rover]
        ];
    }

    public function OutOfTheBorderDataProvider(): array
    {
        $roverSchema1 = new Rover(
            new Direction('N'),
            new Position(
                new Point(1),
                new Point(2)
            )
        );

        $plateau = (new Plateau())->setWidth(1)->setHeight(1);
        $roverEntity1 = (new RoverEntity())->setPlateau($plateau);

        $roverSchema2 = new Rover(
            new Direction('N'),
            new Position(
                new Point(1),
                new Point(2)
            )
        );

        $plateau = (new Plateau())->setWidth(4)->setHeight(4);
        $roverEntity2 = (new RoverEntity())->setPlateau($plateau);

        return [
            [$roverSchema1, $roverEntity1, true],
            [$roverSchema2, $roverEntity2, false]
        ];
    }
}
