<?php

namespace RAPIBundle\DataMapper\Annotation;

use DateTime as GlobalDateTime;
use RAPIBundle\DataMapper\Exception\InvalidTypeException;

/**
 * Class DateTime
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class DateTime extends Annotation
{
    /**
     * @param $value
     * @return null|GlobalDateTime
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

        return $value;
    }
}
