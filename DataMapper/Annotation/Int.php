<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Int
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Int extends Annotation
{
    /**
     * @param $value
     * @return int|null
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return (int)$value;
    }
}
