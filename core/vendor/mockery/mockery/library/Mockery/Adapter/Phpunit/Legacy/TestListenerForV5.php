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
 * @category  Mockery
 * @package   Mockery
 * @copyright Copyright (c) 2010 Pádraic Brady (https://blog.astrumfutura.com)
 * @license   https://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Adapter\Phpunit\Legacy;

class TestListenerForV5 extends \PHPUnit_Framework_BaseTestListener
{
    private $trait;

    public function __construct()
    {
        $this->trait = new TestListenerTrait();
    }

    /**
     * {@inheritdoc}
     */
    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        $this->trait->endTest($test, $time);
    }

    /**
     * {@inheritdoc}
     */
    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->trait->startTestSuite();
    }
}
