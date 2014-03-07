<?php

require_once 'FeatureContext.php';

use Symfony\Component\HttpKernel\Client;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\BrowserKitDriver;

class DeliveryContext extends FeatureContext {

    public function __construct(array $parameters) {
        parent::__construct($parameters);
        $app                    = require __DIR__ . '/../../bootstrap.php';
        $mink                   = new Mink(array(
            'browserkit' => new Session(new BrowserKitDriver(new Client($app))),
        ));
       // $this->userRepository = $app['repository.user'];
        $this->registrationValidator = $app['validator.registration'];
        $this->passwordHasher = $app['service.passwordHasher'];
        $this->activationCodeGenerator = $app['service.activationCodeGenerator'];
        $mink->setDefaultSessionName('browserkit');
        $this->mink             = $mink;
        $this->userHelper       = new DeliveryUserHelper($this->mink,$this->userRepository, $this->registrationValidator, $this->passwordHasher,
                $this->activationCodeGenerator);
        $this->messageHelper = new DeliveryMessageHelper($this->mink);
    }

    /**
     * @Given /^I\'am on site "([^"]*)"$/
     */
    public function iAmOnSite($uri) {
       
        $this->mink->getSession()->visit($uri);
    }

}
