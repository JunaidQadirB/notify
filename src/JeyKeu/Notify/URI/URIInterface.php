<?php

/**
 * An interface for URI.
 * @package Notify
 * @subpackage URI
 */
namespace JeyKeu\Notify\URI;

interface URIInterface
{

    /**
     * Returns the full URL of the current page.
     */
    public function getCurrentUrl();

    /**
     * Returns the last segment of the URL i.e. the page name.
     */
    public function getCurrentPage();

    /**
     * Returns a segment of the URL as specified by the $index variable.
     * 
     * @param int $index
     * @param mixed $url 
     */
    public function getSegment($index, $url = null);

    /**
     * Returns an array with all the segments of the current page or the page
     * specified in the $url parameter.
     * 
     * @param mix $url
     * @return array array of URL segments
     */
    public function getSegments($url = null);

    /**
     * Returns the last segment of the url
     * 
     * @param string $url
     */
    public function getLastSegment($url = null);
}
