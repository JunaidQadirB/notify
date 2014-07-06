<?php

namespace JeyKeu\Notify\Test;

use \JeyKeu\Notify\Notify;

class NotifyNativeTest extends \PHPUnit_Framework_TestCase
{

    public function __construct() {
        $nf = new Notify();
    }

    function testNotifyAdd() {
        $assertHandleEmpty = null;
        $this->assertNotNull($assertHandleEmpty);
    }

    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue() {
        $this->assertTrue(true);
    }

}
