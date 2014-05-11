<?php

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
        $env                         = 'test';
        $app                         = require __DIR__ . '/../../bootstrap.php';
        $mink                        = new Mink(array(
            'browserkit' => new Session(new BrowserKitDriver(new Client($app))),
        ));
        $this->userRepository        = $app[Repository::USER];
        $this->registrationValidator = $app[Validator::REGISTRATION];
        
        $this->passwordHasher          = $app[Service::PASSWORD_HASHER];
        $this->activationCodeGenerator = $app[Service::ACTIVATION_CODE_GENERATOR];
        $this->locationCalculator      = $app[Service::LOCATION_CALCULATOR];
        $this->mapRepository           = $app[Repository::MAP];
        $this->mapTilesRepository      = $app[Repository::MAP_TILES];
        $this->cityRepository          = $app[Repository::CITY];
        $this->activateUserValidator   = $app[Validator::ACTIVATE];
        $app['session.test']           = true;
        $mink->setDefaultSessionName('browserkit');
        $this->mink                    = $mink;

        $this->userHelper = new SilexUserHelper($this->mink, $this->userRepository, $this->registrationValidator, $this->passwordHasher, $this->activationCodeGenerator, $this->activateUserValidator);

        $this->cityHelper    = new SilexCityHelper($this->mink, $this->cityRepository, $this->mapTilesRepository, $this->userRepository, $this->locationCalculator, $this->cityBuildingsRepository, $this->buildingRepository);
        $this->mapHelper     = new MapHelper($this->mapRepository, $this->tileRepository, $this->mapTilesRepository);
        $this->messageHelper = new SilexMessageHelper($this->mink);
    }

    /** @BeforeScenario */
    public function before() {
      
    }

    /** @AfterScenario */
    public function after() {

        $this->userRepository->flush();
        $this->cityRepository->flush();
        $this->cityRepository->flush();
    }

}
