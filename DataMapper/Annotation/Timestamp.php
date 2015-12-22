<?php

namespace RAPIBundle\DataMapper\Annotation;

use DateTime as GlobalDateTime;
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

        if (!$value instanceof GlobalDateTime) {
            throw new InvalidTypeException($value, get_class($this));
        }

        return $value->getTimestamp();
    }
}
