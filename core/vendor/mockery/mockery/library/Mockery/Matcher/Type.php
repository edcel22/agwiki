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

namespace Mockery\Matcher;

class Type extends MatcherAbstract
{
    /**
     * Check if the actual value matches the expected.
     *
     * @param mixed $actual
     * @return bool
     */
    public function match(&$actual)
    {
        if ($this->_expected == 'real') {
            $function = 'is_float';
        } else {
            $function = 'is_' . strtolower($this->_expected);
        }
        if (function_exists($function)) {
            return $function($actual);
        } elseif (is_string($this->_expected)
        && (class_exists($this->_expected) || interface_exists($this->_expected))) {
            return $actual instanceof $this->_expected;
        }
        return false;
    }

    /**
     * Return a string representation of this Matcher
     *
     * @return string
     */
    public function __toString()
    {
        return '<' . ucfirst($this->_expected) . '>';
    }
}
