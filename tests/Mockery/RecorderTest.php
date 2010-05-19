<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

class RecorderTest extends PHPUnit_Framework_TestCase
{

    public function setup ()
    {
        $this->container = new \Mockery\Container;
    }
    
    public function teardown()
    {
        $this->container->mockery_close();
    }

    public function testRecorderWithSimpleObject()
    {
        $mock = $this->container->mock(new MockeryTestSubject);
        $mock->shouldExpect(function ($subject) {
            $user = new MockeryTestSubjectUser($subject);
            $user->doFoo();
        });
        
        $this->assertEquals(1, $mock->foo());
        $mock->mockery_verify();
    }
    
}

class MockeryTestSubject {
    function foo() { return 1; }
}

class MockeryTestSubjectUser {
    public $subject = null;
    function __construct($subject) { $this->subject = $subject; }
    function doFoo () { return $this->subject->foo(); }
}
