<?php

namespace Packfire\Config\Driver;

require_once(__DIR__ . '/ConfigTestSetter.php');

/**
 * Test class for PhpConfig.
 * Generated by PHPUnit on 2012-07-14 at 06:11:25.
 */
class PhpTest extends ConfigTestSetter {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers \Packfire\Config\Driver\PhpConfig::read
     */
    protected function setUp() {
        $this->prepare('\\Packfire\\Config\\Driver\\Php');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

}