<?php

namespace OpenTribes\Core\Interactor;

use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Repository\Map as MapRepository;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\View\City as CityView;

/**
 * Description of CreateCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateCity {

    private $cityRepository;
    private $userRepository;
    private $mapRepository;

    function __construct(CityRepository $cityRepository, MapRepository $mapRepository, UserRepository $userRepository) {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
        $this->mapRepository  = $mapRepository;
    }

    public function process(CreateCityRequest $request, CreateCityResponse $response) {
        $owner = $this->userRepository->findOneByUsername($request->getUsername());
        $x     = $request->getX();
        $y     = $request->getY();
        $name  = $request->getDefaultCityName();

       
        if (!$this->mapRepository->tileIsAccessible($y, $x)) {
            return false;
        }

        if ($this->cityRepository->cityExistsAt($y, $x)) {
            return false;
        }
     
      
        $id = $this->cityRepository->getUniqueId();

        $city           = $this->cityRepository->create($id, $name, $owner,$y, $x);
        $this->cityRepository->add($city);
        $response->city = new CityView($city);
        return true;
    }

}
