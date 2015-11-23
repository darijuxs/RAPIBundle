<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Object
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Object extends Annotation
{
    /**
     * @param $value
     * @return mixed
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return $value;
    }
}
