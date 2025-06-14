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

namespace Mockery\Generator;

class DefinedTargetClass implements TargetClassInterface
{
    private $rfc;
    private $name;

    public function __construct(\ReflectionClass $rfc, $alias = null)
    {
        $this->rfc = $rfc;
        $this->name = $alias === null ? $rfc->getName() : $alias;
    }

    public static function factory($name, $alias = null)
    {
        return new self(new \ReflectionClass($name), $alias);
    }

    public function getName()
    {
        return $this->name;
    }

    public function isAbstract()
    {
        return $this->rfc->isAbstract();
    }

    public function isFinal()
    {
        return $this->rfc->isFinal();
    }

    public function getMethods()
    {
        return array_map(function ($method) {
            return new Method($method);
        }, $this->rfc->getMethods());
    }

    public function getInterfaces()
    {
        $class = __CLASS__;
        return array_map(function ($interface) use ($class) {
            return new $class($interface);
        }, $this->rfc->getInterfaces());
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getNamespaceName()
    {
        return $this->rfc->getNamespaceName();
    }

    public function inNamespace()
    {
        return $this->rfc->inNamespace();
    }

    public function getShortName()
    {
        return $this->rfc->getShortName();
    }

    public function implementsInterface($interface)
    {
        return $this->rfc->implementsInterface($interface);
    }

    public function hasInternalAncestor()
    {
        if ($this->rfc->isInternal()) {
            return true;
        }

        $child = $this->rfc;
        while ($parent = $child->getParentClass()) {
            if ($parent->isInternal()) {
                return true;
            }
            $child = $parent;
        }

        return false;
    }
}
