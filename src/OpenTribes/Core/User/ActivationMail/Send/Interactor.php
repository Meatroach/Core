<?php

namespace OpenTribes\Core\User\ActivationMail\Send;

use OpenTribes\Core\Service\Mailer;
class Interactor{
    protected $mailer;
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }
    public function invoke(Request $request) {
        
        $result = $this->mailer->send($request->getActivationMail());
        return new Response($result);
    }
}