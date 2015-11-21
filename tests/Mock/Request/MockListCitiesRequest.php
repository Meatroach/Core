<?php

namespace OpenTribes\Core\Test\Mock\Request;


use OpenTribes\Core\Request\ListCitiesRequest;

class MockListCitiesRequest implements ListCitiesRequest{
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }



}