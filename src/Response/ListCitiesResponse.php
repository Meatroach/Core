<?php

namespace OpenTribes\Core\Response;


use OpenTribes\Core\View\CityListView;

interface ListCitiesResponse {
    public function getCities();
    public function addCity(CityListView $city);
}