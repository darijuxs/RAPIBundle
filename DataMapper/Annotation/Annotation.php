<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Annotation
 * @package RAPIBundle\DataMapper\Annotation
 */
abstract class Annotation
{
    /**
     * @param array $options
     */
    public function __construct(array $options)
    {

    }

    /**
     * @param $value
     * @return mixed
     */
    abstract public function convert($value);
}
