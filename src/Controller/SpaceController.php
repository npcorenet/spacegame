<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\SpaceService;
use App\Table\PlanetTable;
use App\Table\SolarSystemTable;
use Laminas\Diactoros\Response;

class SpaceController extends AbstractController
{

    public function load(): Response
    {

        if ($this->isAuthenticatedAndValid() === FALSE) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        if(!file_exists(CACHE_DIR.'/planets.json'))
        {
            $solarSystemTable = new SolarSystemTable($this->database);
            $planetTable = New PlanetTable($this->database);

            $spaceData = (new SpaceService($solarSystemTable, $planetTable))->generateSolarSystemArray();

            file_put_contents(CACHE_DIR.'/planets.json', json_encode($spaceData));
            $this->data = ['code' => 200, 'message' => self::CODE200, 'data' => $spaceData];

            return $this->response();

        }

        $spaceData = file_get_contents(CACHE_DIR.'/planets.json');
        $spaceData = json_decode($spaceData);

        $this->data = ['code' => 200, 'message' => self::CODE200, 'data' => $spaceData];

        return $this->response();
    }

}
