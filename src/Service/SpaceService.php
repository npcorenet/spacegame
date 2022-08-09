<?php

namespace App\Service;

use App\Table\PlanetTable;
use App\Table\SolarSystemTable;

class SpaceService
{

    public function __construct(
        private readonly SolarSystemTable $solarSystemTable,
        private readonly PlanetTable $planetTable
    ) {
    }

    public function generateSolarSystemArray(): array
    {
        $spaceData = [];

        $solarData = $this->solarSystemTable->findAll();

        foreach ($solarData as $solar) {
            $spaceData[$solar['id']] = $solar;
            unset($spaceData[$solar['id']]['id']);

            $planets = $this->planetTable->findPlanetsBySolarId($solar['id']);
            foreach ($planets as $planet) {
                $spaceData[$solar['id']]['planets'][$planet['id']] = $planet;
                foreach ($this->planetTable->findMoonsByPlanetId($planet['id']) as $moon) {
                    $spaceData[$solar['id']]['planets'][$planet['id']]['moons'][$moon['id']] = $moon;
                    unset($spaceData[$solar['id']]['planets'][$planet['id']]['moons'][$moon['id']]['id']);
                }

                unset($spaceData[$solar['id']]['planets'][$planet['id']]['id']);
            }
        }

        return $spaceData;
    }

}