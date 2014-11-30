<?php

namespace OpenTribes\Core\Request;


interface LoginRequest extends Request{
    public function getUsername();
    public function getPassword();
} 