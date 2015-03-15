<?php

namespace OpenTribes\Core\Request;


interface RegistrationRequest{
    public function getUsername();
    public function getPassword();
    public function getPasswordConfirm();
    public function getEmail();
    public function getEmailConfirm();
    public function hasAcceptedTerms();
} 