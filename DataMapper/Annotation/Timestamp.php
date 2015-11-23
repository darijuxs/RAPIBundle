<?php

namespace RAPIBundle\DataMapper\Annotation;

use DateTime;
use RAPIBundle\DataMapper\Exception\InvalidTypeException;

/**
 * Class Timestamp
 * @package RAPIBundle\Service\DataMapper\Annotation
 * @Annotation
 */
final class Timestamp extends Annotation
{
    /**
     * @param $value
     * @return int|null
     * @throws InvalidTypeException
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof DateTime) {
            throw new InvalidTypeException($value, get_class($this));
        }

        return $value->getTimestamp();
    }
}
