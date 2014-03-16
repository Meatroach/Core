<?php

namespace OpenTribes\Core\Silex\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of Assets
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Assets {

    const CSS  = 'text/css';
    const PNG  = 'image/png';
    const JPG  = 'image/jpg';
    const JPEG = 'image/jpg';
    const JS   = 'application/javascript';
    const JSON = 'application/json';

    private $contentTypes = array(
        'css'  => self::CSS,
        'png'  => self::PNG,
        'jpg'  => self::JPG,
        'jpeg' => self::JPEG,
        'js'   => self::JS,
        'json' => self::JSON
    );
    private $paths        = array();

    public function __construct(array $paths) {
        $this->paths = $paths;
    }

    public function load($type, $file) {

        foreach ($this->paths as $baseDir) {
            $file = realpath(sprintf("%s/%s/%s", $baseDir, $type, $file));
        }
        if (is_file($file)) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
        }
        $response = new Response(file_get_contents($file), 200, $this->getContentTypByExtension($extension));
        return $response;
    }

    private function getContentTypByExtension($extension) {
        $contentType = isset($this->contentTypes[$extension]) ? $this->contentTypes[$extension] : '';
        return array('Content-Type' => $contentType);
    }

}
