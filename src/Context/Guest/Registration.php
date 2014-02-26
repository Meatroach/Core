<?php

namespace OpenTribes\Core\Domain\Context\Guest;

use OpenTribes\Core\Domain\Repository\User as UserRepository;
use OpenTribes\Core\Domain\Request\Registration as RegistrationRequest;
/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration {
    private $userRepository;

    function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;

    }
    public function process(RegistrationRequest $request){
        
    }
}
