<?php

namespace Unit\Controller;

use App\Controller\PlateauController;
use App\Schema\Plateau as PlateauSchema;
use App\Schema\Point;
use App\Schema\Position;
use App\Service\Interfaces\PlateauServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PlateauControllerTest
 * @package Unit\Controller
 * @coversDefaultClass \App\Controller\PlateauController
 */
class PlateauControllerTest extends TestCase
{
    private $plateauController;
    private $plateauSchema;

    public function setUp(): void
    {
        $this->prepareParameters();

        $plateauService = $this->createMock(PlateauServiceInterface::class);
        $plateauService->method('createPlateau')->willReturn($this->plateauSchema);
        $plateauService->method('getPlateau')->willReturn($this->plateauSchema);

        $this->plateauController = new PlateauController($plateauService);
    }

    /**
     * @covers ::createPlateau
     */
    public function testItShouldHandleCreatePlateauEndpoint()
    {
        $request = new Request();
        $request->request->set('height', 5);
        $request->request->set('width', 5);

        $plateau = $this->plateauController->createPlateau($request);

        $this->assertEquals(new JsonResponse($this->plateauSchema), $plateau);
    }

    /**
     * @covers ::getPlateau
     */
    public function testItShouldHandleGetPlateauEndpoint()
    {
        $request = new Request();
        $request->request->set('id', 1);

        $plateau = $this->plateauController->getPlateau($request);

        $this->assertEquals(new JsonResponse($this->plateauSchema), $plateau);
    }

    public function prepareParameters()
    {
        $this->plateauSchema = new PlateauSchema(
            new Position(
                new Point(5),
                new Point(5)
            )
        );
    }
}
