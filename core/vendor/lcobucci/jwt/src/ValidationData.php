<?php
/**
 * This file is part of Lcobucci\JWT, a simple library to handle JWT and JWS
 *
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace Lcobucci\JWT;

/**
 * Class that wraps validation values
 *
 * @deprecated This component has been removed from the interface in v4.0
 * @see \Lcobucci\JWT\Validation\Validator
 *
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 * @since 2.0.0
 */
class ValidationData
{
    /**
     * The list of things to be validated
     *
     * @var array
     */
    private $items;

    /**
     * The leeway (in seconds) to use when validating time claims
     * @var int
     */
    private $leeway;

    /**
     * Initializes the object
     *
     * @param int $currentTime
     * @param int $leeway
     */
    public function __construct($currentTime = null, $leeway = 0)
    {
        $currentTime  = $currentTime ?: time();
        $this->leeway = (int) $leeway;

        $this->items = [
            'jti' => null,
            'iss' => null,
            'aud' => null,
            'sub' => null
        ];

        $this->setCurrentTime($currentTime);
    }

    /**
     * Configures the id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->items['jti'] = (string) $id;
    }

    /**
     * Configures the issuer
     *
     * @param string $issuer
     */
    public function setIssuer($issuer)
    {
        $this->items['iss'] = (string) $issuer;
    }

    /**
     * Configures the audience
     *
     * @param string $audience
     */
    public function setAudience($audience)
    {
        $this->items['aud'] = (string) $audience;
    }

    /**
     * Configures the subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->items['sub'] = (string) $subject;
    }

    /**
     * Configures the time that "iat", "nbf" and "exp" should be based on
     *
     * @param int $currentTime
     */
    public function setCurrentTime($currentTime)
    {
        $currentTime  = (int) $currentTime;

        $this->items['iat'] = $currentTime + $this->leeway;
        $this->items['nbf'] = $currentTime + $this->leeway;
        $this->items['exp'] = $currentTime - $this->leeway;
    }

    /**
     * Returns the requested item
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return isset($this->items[$name]) ? $this->items[$name] : null;
    }

    /**
     * Returns if the item is present
     *
     * @param string $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return !empty($this->items[$name]);
    }
}
