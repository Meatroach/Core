<?php

namespace OpenTribes\Core;

class Message extends Entity {

    protected $content;

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getContent(){
        return $this->content;
    }
}
