<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (https://blog.astrumfutura.com)
 * @license    https://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Exception;

use Mockery;

class NoMatchingExpectationException extends Mockery\Exception
{
    protected $method = null;

    protected $actual = array();

    protected $mockObject = null;

    public function setMock(Mockery\LegacyMockInterface $mock)
    {
        $this->mockObject = $mock;
        return $this;
    }

    public function setMethodName($name)
    {
        $this->method = $name;
        return $this;
    }

    public function setActualArguments($count)
    {
        $this->actual = $count;
        return $this;
    }

    public function getMock()
    {
        return $this->mockObject;
    }

    public function getMethodName()
    {
        return $this->method;
    }

    public function getActualArguments()
    {
        return $this->actual;
    }

    public function getMockName()
    {
        return $this->getMock()->mockery_getName();
    }
}
