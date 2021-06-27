<?php

namespace App\Tests\Unit\Service;

use App\Builder\PlateauBuilder;
use App\Entity\Plateau;
use App\Repository\Interfaces\PlateauRepositoryInterface;
use App\Service\PlateauService;
use PHPUnit\Framework\TestCase;

/**
 * Class PlateauServiceTest
 * @package App\Tests\Unit\Service
 * @coversDefaultClass \App\Service\PlateauService
 */
class PlateauServiceTest extends TestCase
{
    private $plateauRepository;
    private $plateauEntity;

    public function setUp(): void
    {
        $this->prepareParameters();

        $plateauRepository = $this->createMock(PlateauRepositoryInterface::class);
        $plateauRepository->method('getPlateau')->willReturn($this->plateauEntity);

        $this->plateauRepository = new PlateauService($plateauRepository);
    }

    /**
     * @covers ::getPlateau
     */
    public function testItShouldHandleGetPlateau()
    {
        $plateauId = 1;
        $expected = PlateauBuilder::createSchemaFromEntity($this->plateauEntity);
        $plateau = $this->plateauRepository->getPlateau($plateauId);

        $this->assertEquals($expected, $plateau);
    }

    /**
     * @covers ::createPlateau
     */
    public function testItShouldHandleCreatePlateau()
    {
        $width = 5;
        $height = 5;
        $expected = PlateauBuilder::createSchemaFromEntity($this->plateauEntity);
        $plateau = $this->plateauRepository->createPlateau($width, $height);

        $this->assertEquals($expected, $plateau);
    }

    public function prepareParameters()
    {
        $this->plateauEntity = (new Plateau())
            ->setWidth(5)
            ->setHeight(5);
    }
}
