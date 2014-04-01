<?php

namespace OpenTribes\Core\Request;

/**
 * Description of ViewCities
 *
 * @author BlackScorp<witalimik@web.de>
 */
class ViewCities {
   private $username;
   function __construct($username) {
       $this->username = $username;
   }
   public function getUsername() {
       return $this->username;
   }


}
