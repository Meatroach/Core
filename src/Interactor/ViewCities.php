<?php

namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Response\ViewCities as ViewCitiesResponse;
use OpenTribes\Core\Request\ViewCities as ViewCitiesRequest;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\View\City as CityView;
/**
 * Description of ViewCities
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCities {
    private $userRepository;
    private $cityRepository;
    function __construct(UserRepository $userRepository,CityRepository $cityRepository) {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
    }
    public function process(ViewCitiesRequest $request,ViewCitiesResponse $response){
        $owner = $this->userRepository->findOneByUsername($request->getUsername());
        if(!$owner){
            return false;
        }
        $cities = $this->cityRepository->findAllByOwner($owner);
        if(count($cities) < 0){
            return false;
        }
        foreach($cities as $city){
            $response->cities[]=new CityView($city);
        }
        return true;
    }
}
