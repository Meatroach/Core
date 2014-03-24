<?php

require_once 'FeatureContext.php';

use Symfony\Component\HttpKernel\Client;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\BrowserKitDriver;
use OpenTribes\Core\Silex\Validator;
use OpenTribes\Core\Silex\Service;
use OpenTribes\Core\Silex\Repository;

class SilexContext extends FeatureContext {

    public function __construct(array $parameters) {
        parent::__construct($parameters);
        $env = 'test';
        $app                         = require __DIR__ . '/../../bootstrap.php';
        $mink                        = new Mink(array(
            'browserkit' => new Session(new BrowserKitDriver(new Client($app))),
        ));
        $this->userRepository        = $app[Repository::USER];
        $this->registrationValidator = $app[Validator::REGISTRATION];

        $this->passwordHasher          = $app[Service::PASSWORD_HASHER];
        $this->activationCodeGenerator = $app[Service::ACTIVATION_CODE_GENERATOR];
        $app['session.test'] = true;
        $mink->setDefaultSessionName('browserkit');
        $this->mink       = $mink;
        $this->userHelper = new DeliveryUserHelper($this->mink, $this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator);
        $this->cityHelper = new CityHelper($this->cityRepository, $this->mapRepository, $this->userRepository,$this->locationCalculator);

        $this->messageHelper = new DeliveryMessageHelper($this->mink);
    }

    /** @BeforeScenario */
    public function before($event) {
        
    }

    /** @AfterScenario */
    public function after($event) {

        $this->userRepository->flush();
    }

}
