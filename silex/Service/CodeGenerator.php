<?php

namespace OpenTribes\Core\Silex\Service;

use OpenTribes\Core\Service\ActivationCodeGenerator;

/**
 * Description of CodeGenerator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CodeGenerator implements ActivationCodeGenerator {
    private $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $length = 0;
    private $code = '';
    public function __construct($length) {
        $this->length = $length;
    }

    public function create() {
        $this->createRandomString();
        return $this->code;
    }
    
    private function createRandomString(){
        $chars = strlen($this->pool)-1;
        for($i = 0;$i<$this->length;$i++){
            $this->code.= $this->pool[mt_rand(0, $chars)];
        }
    }

}
