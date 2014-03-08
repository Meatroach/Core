<?php

require_once 'FeatureContext.php';

use Symfony\Component\HttpKernel\Client;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\BrowserKitDriver;
use OpenTribes\Core\Validator;
use OpenTribes\Core\Service;
use OpenTribes\Core\Repository;

class DeliveryContext extends FeatureContext {

    public function __construct(array $parameters) {
        parent::__construct($parameters);
        $app                           = require __DIR__ . '/../../bootstrap.php';
        $mink                          = new Mink(array(
            'browserkit' => new Session(new BrowserKitDriver(new Client($app))),
        ));
        $this->userRepository          = $app[Repository::USER];
        $this->registrationValidator   = $app[Validator::REGISTRATION];
      
        $this->passwordHasher          = $app[Service::PASSWORD_HASHER];
        $this->activationCodeGenerator = $app[Service::ACTIVATION_CODE_GENERATOR];
       
        $mink->setDefaultSessionName('browserkit');
        $this->mink                    = $mink;
        $this->userHelper              = new DeliveryUserHelper($this->mink, $this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);
        $this->messageHelper           = new DeliveryMessageHelper($this->mink);
    }

    /** @BeforeScenario */
    public function before($event) {
       
    }

    /** @AfterScenario */
    public function after($event) {
     
        $this->userHelper->clear();
       
    }

}
