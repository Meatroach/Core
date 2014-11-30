<?php
namespace OpenTribes\Core\UseCase;

use OpenTribes\Core\Request\Request;
use OpenTribes\Core\Response\Response;

interface UseCase {
    public function process(Request $request,Response $response);
} 