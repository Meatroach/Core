<?php

namespace OpenTribes\Core\Request;


interface LoginRequest{
    public function getUsername();
    public function getPassword();
} 