<?php
namespace Opentribes\Core\Silex\providers;

use OpenTribes\Core\Service\PasswordHasher as PasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class CSRFTokenHasher implements PasswordHasherInterface {
    private $session;
    
    public function __construct(Session $session) {
        $this->session = &$session;
    }
    
    public function hash($rawPassword) {
        $token = $this->session->getId();
        if (function_exists('password_hash')) {
            return password_hash($token , PASSWORD_DEFAULT);
        }
        
        $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
        $salt = base64_encode($salt);
        $salt = str_replace('+', '.', $salt);
        $hash = crypt($token , '$2y$10$' . $salt . '$');
        return $hash;
    }
    
    public function verify($hash, $rawPassword) {
        $token = $this->session->getId();
        if (function_exists('password_verify')) {
            return password_verify($expectedToken, $token );
        }
        
        return crypt($expectedToken, $token ) === $token ;
    }
}
