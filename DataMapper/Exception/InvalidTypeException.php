<?php

namespace RAPIBundle\DataMapper\Exception;

use Exception;

/**
 * Class InvalidTypeException
 * @package RAPIBundle\DataMapper\Exception
 */
class InvalidTypeException extends Exception
{
    public function __construct($value, $class)
    {
        parent::__construct(sprintf('Values "%s" is not valid annotation type of %s', $value, $class));
    }
}
