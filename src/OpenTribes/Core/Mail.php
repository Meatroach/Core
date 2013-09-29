<?php
/**
 * This file is part of the "Open Tribes" Core Module.
 *
 * @package    OpenTribes\Core
 * @author     Witali Mik <mik@blackscorp.de>
 * @copyright  (c) 2013 BlackScorp Games
 * @license    For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */
namespace OpenTribes\Core;
/**
 * Mail Entity
 */
class Mail extends Entity {
    /**
     * @var String $body
     */
    protected $body;
    /**
     * @var String $recipient
     */
    protected $recipient;
    /**
     * @var String $subject
     */
    protected $subject;
    /**
     * @return String $body
     */
    public function getBody() {
        return $this->body;
    }
    /**
     * @return String $recipient
     */
    public function getRecipient() {
        return $this->recipient;
    }
    /**
     * @return String $subject
     */
    public function getSubject() {
        return $this->subject;
    }
    /**
     * @param String $body
     * @return \OpenTribes\Core\Mail
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
    /**
     * @param String $recipient
     * @return \OpenTribes\Core\Mail
     */
    public function setRecipient($recipient) {
        $this->recipient = $recipient;
        return $this;
    }
    /**
     * @param String $subject
     * @return \OpenTribes\Core\Mail
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

}
