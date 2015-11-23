<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Float
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Float extends Annotation
{
    /**
     * @param $value
     * @return float|null
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return (float)$value;
    }
}
