<?php

namespace Kumatch\Test;

use Kumatch\Path;

class PathTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function providePathMethods()
    {
        return array(
            array("normalize"),
            array("join"),
            array("dirname"),
            array("basename"),
            array("extname"),
        );
    }

    /**
     * @test
     * @dataProvider providePathMethods
     * @expectedException \Exception
     */
    public function throwExceptionIfWindowsPlatform($method)
    {
        $mock = $this->getMockClass('Kumatch\Path', array('isWindowsPlatform'));
        $mock::staticExpects($this->any())
            ->method('isWindowsPlatform')
            ->will($this->returnValue(true));

        call_user_func_array(array($mock, $method), array("foo"));
    }

    /**
     * @test
     * @dataProvider providePathMethods
     */
    public function throwNotExceptionIfNotWindowsPlatform($method)
    {
        $mock = $this->getMockClass('Kumatch\Path', array('isWindowsPlatform'));
        $mock::staticExpects($this->any())
            ->method('isWindowsPlatform')
            ->will($this->returnValue(false));

        call_user_func_array(array($mock, $method), array("foo"));
    }
}