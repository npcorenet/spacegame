<?php
declare(strict_types=1);

namespace App\Controller;

use App\Table\PlanetTable;
use App\Table\SolarSystemTable;
use Laminas\Diactoros\Response;

class SpaceController extends AbstractController
{

    public function load(): Response
    {
        $spaceData = [];

        if (!$this->isAuthenticatedAndValid()) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        $solarSystemTable = new SolarSystemTable($this->database);
        $solarData = $solarSystemTable->findAll();

        if(!file_exists(CACHE_DIR.'/planets.json'))
        {

            foreach ($solarData as $solar) {
                $spaceData[$solar['id']] = $solar;
                unset($spaceData[$solar['id']]['id']);

                $planetTable = new PlanetTable($this->database);
                $planets = $planetTable->findPlanetsBySolarId($solar['id']);
                foreach ($planets as $planet) {
                    $spaceData[$solar['id']]['planets'][$planet['id']] = $planet;
                    foreach ($planetTable->findMoonsByPlanetId($planet['id']) as $moon) {
                        $spaceData[$solar['id']]['planets'][$planet['id']]['moons'][$moon['id']] = $moon;
                        unset($spaceData[$solar['id']]['planets'][$planet['id']]['moons'][$moon['id']]['id']);
                    }

                    unset($spaceData[$solar['id']]['planets'][$planet['id']]['id']);
                }
            }

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
