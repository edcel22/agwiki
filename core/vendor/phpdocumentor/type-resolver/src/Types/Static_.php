<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      https://phpdoc.org
 */

namespace phpDocumentor\Reflection\Types;

use phpDocumentor\Reflection\Type;

/**
 * Value Object representing the 'static' type.
 *
 * Self, as a Type, represents the class in which the associated element was called. This differs from self as self does
 * not take inheritance into account but static means that the return type is always that of the class of the called
 * element.
 *
 * See the documentation on late static binding in the PHP Documentation for more information on the difference between
 * static and self.
 */
final class Static_ implements Type
{
    /**
     * Returns a rendered output of the Type as it would be used in a DocBlock.
     */
    public function __toString() : string
    {
        return 'static';
    }
}
