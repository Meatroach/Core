<?php

namespace OpenTribes\Core\Response;


use OpenTribes\Core\View\DirectionView;

interface ListDirectionsResponse {
    public function addDirection(DirectionView $direction);
}