<?php

namespace OpenTribes\Core\Silex\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Validator\Constraints\DateTime;

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

    public function load(Request $request, $type, $file) {

        foreach ($this->paths as $baseDir) {
            $file = realpath(sprintf("%s/%s/%s", $baseDir, $type, $file));
        }
        if (!$file) {
            return new Response('Not Found', 404);
        }

        $response  = new StreamedResponse();
        $extension = pathinfo($file, PATHINFO_EXTENSION);
 
        $eTag    = md5($file);
        $expireDate = new DateTime();
        $expireDate->modify("+1 month");
        $response->setCallback(function() use($file){
            readfile($file);
        });
     
        $response->headers->set('Content-Type', $this->getContentTypByExtension($extension));
        $response->headers->set('Content-Encoding','gzip');
        $response->setEtag($eTag);
        $response->setExpires($expireDate);
        $response->setPublic();
    
        $response->isNotModified($request);
        return $response;
    }

    private function getContentTypByExtension($extension) {
        return isset($this->contentTypes[$extension]) ? $this->contentTypes[$extension] : '';
    }

}
