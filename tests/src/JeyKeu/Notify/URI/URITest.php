<?php namespace JeyKeu\Notify\URI\Test;

use JeyKeu\Notify\URI\NativeURI;
use JeyKeu\Notify\URI;

/**
 * Description of TestURL
 *
 * @author jeykeu
 */
class URITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Notify
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new NativeURI();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * @covers NativeURI::getCurrentUrl
     * @return array
     */
    public function testGetCurrentUrl()
    {
        $expected = 'http://localhost/NotifyNativeDemo/index.php';
        $actual   = $this->object->getCurrentUrl();
        $this->assertEquals($expected, $actual);
        return array('url' => $actual);
    }

    /**
     * @covers NativeURI::getCurrentPage
     * @depends testGetCurrentUrl
     */
    public function testGetCurrentPage($data)
    {
        $expected = 'index.php';
        $actual   = $this->object->getCurrentPage();
        $this->assertEquals($expected, $actual, 'Should return index.php');
    }

    /**
     * @covers NativeURI::getSegments
     * @depends testGetCurrentUrl
     * @param array $data
     */
    public function testGetSegments($data)
    {
        $url      = $data['url'];
        $expected = array('localhost', 'NotifyNativeDemo', 'index.php');

        $actual = $this->object->getSegments($url);
        $this->assertEquals($expected, $actual);
        
        $actual = $this->object->getSegments();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers NativeURI::getLastSegment
     * @depends testGetCurrentUrl
     */
    public function testGetLastSegment($data)
    {
        $url      = $data['url'];
        $actual   = $this->object->getLastSegment($url);
        $expected = "index.php";
        $this->assertEquals($expected, $actual);
        
        $actual   = $this->object->getLastSegment();
        $expected = "index.php";
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers NativeURI::getSegment
     * @depends testGetCurrentUrl
     */
    public function testGetSegment($data)
    {
        $url      = $data['url'];
        $index0   = 0;
        $expected = 'localhost';
        $actual   = $this->object->getSegment($index0, $url);
        $this->assertEquals($expected, $actual);
        
        $index1   = 1;
        $expected = 'NotifyNativeDemo';
        $actual   = $this->object->getSegment($index1, $url);
        $this->assertEquals($expected, $actual);
    }
}
