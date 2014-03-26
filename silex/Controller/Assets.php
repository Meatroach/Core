<?php

namespace OpenTribes\Core\Silex\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Description of Assets
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Assets {

    const CSS = 'text/css';
    const PNG = 'image/png';
    const JPG = 'image/jpg';
    const JPEG = 'image/jpg';
    const JS = 'application/javascript';
    const JSON = 'application/json';

    private $contentTypes = array(
        'css'  => self::CSS,
        'png'  => self::PNG,
        'jpg'  => self::JPG,
        'jpeg' => self::JPEG,
        'js'   => self::JS,
        'json' => self::JSON
    );
    private $paths = array();

    public function __construct(array $paths) {
        $this->paths = $paths;
    }

    public function load($type, $file) {

        foreach ($this->paths as $baseDir) {
            $file = realpath(sprintf("%s/%s/%s", $baseDir, $type, $file));
        }


        $response = new BinaryFileResponse($file, Response::HTTP_OK, array(), true, ResponseHeaderBag::DISPOSITION_INLINE, true, true);
        $expireDate = new DateTime();
        $expireDate->modify("+1 month");
        $response->setExpires($expireDate);
        return $response;
    }

    private function getContentTypByExtension($extension) {
        return isset($this->contentTypes[$extension]) ? $this->contentTypes[$extension] : '';
    }

}
