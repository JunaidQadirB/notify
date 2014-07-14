<?php namespace JeyKeu\Notify\URI;

/**
 * Description of CodeIgniterURI
 *
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class CodeIgniterURI implements URIInterface
{

    public function getCurrentPage()
    {

    }

    public function getCurrentUrl()
    {
        return current_url();
    }

    public function getSegment($index, $url = null)
    {

    }

    public function getSegments($url = null)
    {

    }

    public function getLastSegment($url = null)
    {
        return $this->CI->uri->rsegment_array($this->getCurrentUrl());
    }
//put your code here
}
