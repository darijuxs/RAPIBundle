<?php

namespace RAPIBundle\DataMapper\Annotation;

use RAPIBundle\DataMapper\Exception\InvalidTypeException;

/**
 * Class Collection
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Collection extends Annotation
{
    /**
     * @param $value
     * @return null|array
     * @throws InvalidTypeException
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        if (!is_array($value)) {
            throw new InvalidTypeException($value, get_class($this));
        }

        return $value;
    }
}
