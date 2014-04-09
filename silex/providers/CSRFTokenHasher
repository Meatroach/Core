<?php
namespace Opentribes\Core\Silex\providers;

use OpenTribes\Core\Silex\Service\PasswordHasher;
use Silex\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Session\Session;

class CSRFTokenHasher implements ServiceProviderInterface {
    public function register(Application $app) {
        $hasher = new PasswordHasher();
        $session = new Session();
        
        $id = $session->getId();
        $app['csrf_token'] = $hasher->hash($id);
    }
    
    public function boot(Application $app) {
    }
}
