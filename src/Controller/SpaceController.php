<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Service\SpaceService;
use App\Table\PlanetTable;
use App\Table\SolarSystemTable;
use Laminas\Diactoros\Response;

class SpaceController
{

    public function __construct(
        private readonly SolarSystemTable $solarSystemTable,
        private readonly PlanetTable $planetTable
    )
    {
    }

    public function load(): Response
    {
        if (!file_exists(CACHE_DIR . '/planets.json')) {
            $spaceData = (new SpaceService($this->solarSystemTable, $this->planetTable))->generateSolarSystemArray();

            file_put_contents(CACHE_DIR . '/planets.json', json_encode($spaceData));

            return new JsonResponse(200, $spaceData);
        }

        $spaceData = file_get_contents(CACHE_DIR . '/planets.json');
        $spaceData = json_decode($spaceData, true);

        return new JsonResponse(200, $spaceData);
    }

}
