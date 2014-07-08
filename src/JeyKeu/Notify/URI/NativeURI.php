<?php namespace JeyKeu\Notify\URI;

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

    public function getCurrentPage()
    {
        $url = $this->getCurrentUrl();
    }

    public function getCurrentUrl()
    {
        $this->host   = $_SERVER['HTTP_HOST'];
        $this->uri    = $_SERVER['REQUEST_URI'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];

        return $this->scheme . "://" . $this->host . $this->uri;
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
            $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
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
        print_r($this->getSegment($len));

        return $this->getSegment($len);
    }
//put your code here
}
