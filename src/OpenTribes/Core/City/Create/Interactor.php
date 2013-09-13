<?php

namespace OpenTribes\Core\City\Create;

use OpenTribes\Core\City\Repository as CityRepository;
use OpenTribes\Core\Map\Tile\Repository as MapTileRepository;
use OpenTribes\Core\City\Create\Exception\NotAccessable as TileNotAccessableException;
use OpenTribes\Core\City\Create\Exception\Exists as CityExistsException;
class Interactor{
    protected $cityRepository;
    protected $mapTileRepository;
    public function __construct(CityRepository $cityRepository,MapTileRepository $mapTileRepository) {
        $this->cityRepository = $cityRepository;
        $this->mapTileRepository = $mapTileRepository;
    }
    public function __invoke(Request $request) {
        $user = $request->getUser();
        $mapTile = $this->mapTileRepository->findByLocation($request->getX(), $request->getY());
       
        $city = $this->cityRepository->findByLocation($request->getX(), $request->getY());
        $tile = $mapTile->getTile();

       
        if(!$tile->getAccessable()) throw new TileNotAccessableException;
        if($city) throw new CityExistsException;
        
        $newCity = $this->cityRepository->create();
        $newCity->setName($request->getCityName());
        $newCity->setOwner($user);
        $this->cityRepository->add($newCity);
        return new Response($newCity);
    }
}