<?php
namespace OpenTribes\Core\Silex\Controller;

use OpenTribes\Core\Silex\Response\IndexResponse;
use OpenTribes\Core\UseCase\LoginUseCase;


class IndexController {
    private $loginUseCase;
    public function __construct(LoginUseCase $loginUseCase){
        $this->loginUseCase = $loginUseCase;
    }
    public function indexAction(){

        $response = new IndexResponse();

        return $response;
    }
} 