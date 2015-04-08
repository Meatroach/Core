<?php
namespace OpenTribes\Core\Silex\Controller;

use OpenTribes\Core\Silex\Request\IndexRequest;
use OpenTribes\Core\Silex\Response\IndexResponse;
use OpenTribes\Core\UseCase\LoginUseCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class IndexController {
    private $loginUseCase;
    public function __construct(LoginUseCase $loginUseCase){
        $this->loginUseCase = $loginUseCase;
    }
    public function indexAction(Request $httpRequest){

        $response = new IndexResponse();
        $request = new IndexRequest($httpRequest);
        if($httpRequest->isMethod('POST')){
            $this->loginUseCase->process($request,$response);

            if(!$response->hasErrors()){
                $httpRequest->getSession()->set('username',$response->username);
                return new RedirectResponse('/game');
            }
        }
        return $response;
    }
} 