<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class String
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class String extends Annotation
{
    /**
     * @param $value
     * @return null|string
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return (string)$value;
    }
}
