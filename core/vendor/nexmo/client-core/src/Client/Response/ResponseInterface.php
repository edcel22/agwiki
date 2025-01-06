<?php
/**
 * Nexmo Client Library for PHP
 *
 * @copyright Copyright (c) 2016 Nexmo, Inc. (https://nexmo.com)
 * @license   https://github.com/Nexmo/nexmo-php/blob/master/LICENSE.txt MIT License
 */

namespace Nexmo\Client\Response;


interface ResponseInterface
{
    public function getData();
    public function isError();
    public function isSuccess();
}