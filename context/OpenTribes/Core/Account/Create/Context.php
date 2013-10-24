<?php

namespace OpenTribes\Core\Account\Create;

use OpenTribes\Core\User\Role as UserRole;
class Context {

    public function execute(Request $request,UserRole $role ) {

        $userCreateValidationRequest = new UserCreateValidationRequest($row['username'], $row['password'], $row['email'], $row['password_confirm'], $row['email_confirm']);


        $userCreateValidationInteractor = new UserCreateValidationInteractor($this->userRepository, $this->userValidator);

        $userCreateInteractor = new UserCreateInteractor(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->hasher, $this->codeGenerator
        );
        $activationMailCreateInteractor = new ActivationMailCreateInteractor($this->activationMailRepository);
        $activationMailSendInteractor = new ActivationMailSendInteractor($this->mailer);

        try {
            $this->userCreateValidationResponse = $userCreateValidationInteractor->invoke($userCreateValidationRequest);
            //create user account
            $userCreateRequest = new UserCreateRequest($this->userCreateValidationResponse, 'Guest');
            $this->userCreateResponse = $userCreateInteractor->invoke($userCreateRequest);
            //Create activation Mail
            $activationMailCreateRequest = new ActivationMailCreateRequest($this->userCreateResponse);
            $this->activationMailCreateResponse = $activationMailCreateInteractor->invoke($activationMailCreateRequest);
            //Modify and send Activation Mail
            $activationMailSendRequest = new ActivationMailSendRequest($this->activationMailCreateResponse);
            $this->activationMailSendResponse = $activationMailSendInteractor->invoke($activationMailSendRequest);
        } catch (\InvalidArgumentException $e) {

            $this->exception = $e;
            $this->messageHelper->setMessages($this->userValidator->getErrors());
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

}
