<?php

namespace RAPIBundle\DataMapper\Exception;

use Exception;

/**
 * Class InvalidGetterNameException
 * @package RAPIBundle\DataMapper\Exception
 */
class InvalidGetterNameException extends Exception
{
    public function __construct($method, array $validPrefixes)
    {
        parent::__construct(sprintf(
            'Method "%s" is invalid "__get" method. Valid "__get" method should start with [%s] prefix',
            $method,
            implode(", ", $validPrefixes)
        ));
    }
}
