<?php

namespace OpenTribes\Core\Silex\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;

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

    public function load(Request $request,$type, $file) {

        foreach ($this->paths as $baseDir) {
            $file = realpath(sprintf("%s/%s/%s", $baseDir, $type, $file));
        }
        
        $expireDate = new DateTime();
        $expireDate->modify("+1 month");

        $response = new BinaryFileResponse($file);
        $response->setAutoEtag();
        $response->setAutoLastModified();
        $response->setPublic();
        $response->setExpires($expireDate);
        $response->isNotModified($request);
        $response->headers->set('Content-Type', $this->getContentTypByExtension($response->getFile()->getExtension()));
        $response->headers->set('Content-Encoding','gzip');
        return $response;
    }

    private function getContentTypByExtension($extension) {
        return isset($this->contentTypes[$extension]) ? $this->contentTypes[$extension] : '';
    }

}
