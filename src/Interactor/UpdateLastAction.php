<?php
namespace OpenTribes\Core\Interactor;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Response\UpdateLastAction as UpdateLastActionResponse;
use OpenTribes\Core\Request\UpdateLastAction as UpdateLastActionRequest;
class UpdateLastAction{
    private $userRepository;
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    public function process(UpdateLastActionRequest $request,UpdateLastActionResponse $response){
       
        $user = $this->userRepository->findOneByUsername($request->getUsername());
        if(!$user){
            return false;
        }
       
        $user->setLastAction($request->getDatetime());
        $response->lastAction = $user->getLastAction();
        return true;
    }
}