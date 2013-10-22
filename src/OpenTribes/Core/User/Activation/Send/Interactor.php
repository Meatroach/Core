<?php

namespace OpenTribes\Core\User\ActivationMail\Send;

use OpenTribes\Core\Service\Mailer as MailSender;
use OpenTribes\Core\User\ActivationMail\Repository as ActivationMailRepository;
class Interactor{
    protected $mailSender;
    protected $activationMailRepository;
    public function __construct(MailSender $mailSender,ActivationMailRepository $activationMailRepository) {
        $this->mailSender = $mailSender;
        $this->activationMailRepository = $activationMailRepository;
    }
    public function invoke(Request $request) {
        $activationMail = $this->activationMailRepository->findByUser($request->getUser());
        $result = $this->mailSender->send($activationMail);
        return new Response($result);
    }
}