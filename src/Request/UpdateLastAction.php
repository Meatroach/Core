<?php



namespace OpenTribes\Core\Request;


class UpdateLastAction
{
    private $datetime;
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
        $this->datetime = new \DateTime;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;
    }


}
