<?php
/**
 * @see       https://github.com/zendframework/zend-diactoros for the canonical source repository
 * @copyright Copyright (c) 2015-2017 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Zend\Diactoros;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

use function strtolower;

/**
 * HTTP Request encapsulation
 *
 * Requests are considered immutable; all methods that might change state are
 * implemented such that they retain the internal state of the current
 * message and return a new instance that contains the changed state.
 */
class Request implements RequestInterface
{
    use RequestTrait;

    /**
     * @param null|string|UriInterface $uri URI for the request, if any.
     * @param null|string $method HTTP method for the request, if any.
     * @param string|resource|StreamInterface $body Message body, if any.
     * @param array $headers Headers for the message, if any.
     * @throws Exception\InvalidArgumentException for any invalid value.
     */
    public function __construct($uri = null, string $method = null, $body = 'php://temp', array $headers = [])
    {
        $this->initialize($uri, $method, $body, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders() : array
    {
        $headers = $this->headers;
        if (! $this->hasHeader('host')
            && $this->uri->getHost()
        ) {
            $headers['Host'] = [$this->getHostFromUri()];
        }

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($header) : array
    {
        if (! $this->hasHeader($header)) {
            if (strtolower($header) === 'host'
                && $this->uri->getHost()
            ) {
                return [$this->getHostFromUri()];
            }

            return [];
        }

        $header = $this->headerNames[strtolower($header)];

        return $this->headers[$header];
    }
}
