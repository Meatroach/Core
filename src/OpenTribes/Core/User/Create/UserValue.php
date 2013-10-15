<?php

namespace OpenTribes\Core\User\Create;

use OpenTribes\Core\User\UserValue as BaseUserValue;
class UserValue extends BaseUserValue{
    
    protected $acceptedTermsAndConditions;
   
    public function setIsAcceptedTermsAndConditions($acceptedTermsAndConditions){
        $this->acceptedTermsAndConditions = $acceptedTermsAndConditions;
    }
    public function getIsAcceptedTermsAndConditions(){
        return $this->acceptedTermsAndConditions;
    }
            
}
