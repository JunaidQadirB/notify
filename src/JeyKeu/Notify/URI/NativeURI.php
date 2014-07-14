<?php namespace JeyKeu\Notify\URI;

use JeyKeu\Notify\URI\URIInterface;

/**
 * Description of NativeURI
 *
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class NativeURI implements URIInterface
{

    protected $host;
    protected $scheme;
    protected $uri;

    public function __construct()
    {

        $this->host   = $_SERVER['HTTP_HOST'];
        $this->uri    = $_SERVER['REQUEST_URI'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];
    }

    private function trimScheme($url)
    {
        $pattern = "/((ftp|http(s){0,1}){0,1}:\/\/)(www.){0,1}/";
        return preg_replace($pattern, "", $url);
    }

    public function getCurrentUrl()
    {
        $this->host   = $_SERVER['HTTP_HOST'];
        $this->uri    = $_SERVER['REQUEST_URI'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];

        return $this->scheme . "://" . $this->host . $this->uri;
    }

    public function getCurrentPage()
    {
        $url      = $this->trimScheme($this->getCurrentUrl());
        $segments = explode("/", $url);
        return $segments[sizeof($segments) - 1];
    }

    /**
     * Returns a specific segment as specified by the $index variable.
     *
     * @param int $index zero-based index
     */
    public function getSegment($index, $url = null)
    {
        if (empty($url)) {
            $url = $this->getCurrentUrl();
        }
        $segments = $this->getSegments();

        return $segments[$index];
    }

    public function getSegments($url = null)
    {
        if (empty($url)) {
            $url = $this->trimScheme($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        } else {
            $url = $this->trimScheme($url);
        }


        $segments = explode("/", $url);

        return $segments;
    }

    public function getLastSegment($url = null)
    {
        if (empty($url)) {
            $url = $this->getCurrentUrl();
        }
        $segments = $this->getSegments($url);
        $len      = sizeof($segments) - 1;

        return $this->getSegment($len);
    }
//put your code here
}
