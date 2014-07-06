<?php

namespace JeyKeu\Notify\Test;
use JeyKeu\Notify;
class NotifyTest extends \PHPUnit_Framework_TestCase
{
    public function __construct() {
        $nf = new Notify();
        
    }

    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {
        $this->assertTrue(true);
    }
}
