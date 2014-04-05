<?php

use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Repository\Tile as TileRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;

class MapHelper {

    private $mapRepository;
    private $tileRepository;
    private $mapTilesRepository;

    public function __construct(MapRepository $mapRepository, TileRepository $tileRepository, MapTilesRepository $mapTilesRepository) {
        $this->mapRepository  = $mapRepository;
        $this->tileRepository = $tileRepository;
        $this->mapTilesRepository = $mapTilesRepository;
    }

    public function createMap($mapName, array $grid) {
        $mapId = $this->mapRepository->getUniqueId();
        $map = $this->mapRepository->create($mapId,$mapName);

        foreach ($grid as $y => $positions) {
            foreach ($positions as $x => $tileName) {
                $tile = $this->tileRepository->findByName($tileName);
                if(!$tile){
                    throw new Exception(sprintf("Tile %s not exists in Repository",$tileName));
                }
                $map->addTile($tile, $y, $x);
                $map->setWidth(max($x, $map->getWidth()));
                $map->setHeight(max($y, $map->getHeight()));
            }
        }
        $this->mapTilesRepository->add($map);
        $this->mapRepository->add($map);
    }

}
