<?php

namespace OpenTribes\Core\Mail\Send;

use OpenTribes\Core\Service\Mailer;
class Interactor{
    private $mailer = null;
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }
    public function invoke(Request $request){
        
    }
}
