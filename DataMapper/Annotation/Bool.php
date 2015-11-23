<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Bool
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Bool extends Annotation
{
    /**
     * @param $value
     * @return bool|null
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return (bool)$value;
    }
}
