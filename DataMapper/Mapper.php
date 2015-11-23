<?php

namespace RAPIBundle\DataMapper;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class Mapper
 * @package RAPIBundle\DataMapper
 */
abstract class Mapper
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * @return AnnotationReader
     */
    public function getAnnotationReader()
    {
        return $this->annotationReader;
    }
}
