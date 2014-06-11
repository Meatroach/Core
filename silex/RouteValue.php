<?php

namespace OpenTribes\Core\Silex;

abstract class RouteValue
{
    const TEMPLATE        = 'template';
    const SUCCESS_HANDLER = 'successHandler';
    const ERROR_HANDLER   = 'errorHandler';
    const SUB_REQUESTS    = 'subRequests';
}