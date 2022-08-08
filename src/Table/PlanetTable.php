<?php
declare(strict_types=1);

namespace App\Table;

class PlanetTable extends AbstractTable
{

    public function findPlanetsBySolarId(int $id): array|bool
    {
        return $this->query->from($this->getTableName())->where(['solarSystem' => $id, 'moon' => null])->fetchAll();
    }

    public function findMoonsByPlanetId(int $id): array|bool
    {
        return $this->query->from($this->getTableName())->where(['moon' => $id])->orderBy('distance')->fetchAll();
    }

}
