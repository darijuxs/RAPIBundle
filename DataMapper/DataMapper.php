<?php

namespace RAPIBundle\DataMapper;

use ReflectionClass;
use ReflectionMethod;
use Doctrine\ORM\PersistentCollection as ORMCollection;
use Doctrine\ODM\MongoDB\PersistentCollection as ODMCollection;
use RAPIBundle\DataMapper\Annotation\Object;
use RAPIBundle\DataMapper\Exception\InvalidGetterNameException;
use RAPIBundle\DataMapper\Annotation\Annotation;
use RAPIBundle\DataMapper\Annotation\Mapper as MapperAnnotation;

/**
 * Class DataMapper
 * @package RAPIBundle\DataMapper
 */
class DataMapper extends Mapper
{
    /**
     * @param $object
     * @param array $filter
     * @param int $level
     * @return array|null
     */
    public function objectMapper($object, array $filter = null, $level = 0)
    {
        $results = [];

        $objectName = $this->getClassName($object);

        $reflectionClass = new ReflectionClass($objectName);

        if ($this->getAnnotationReader()->getClassAnnotation($reflectionClass, MapperAnnotation::class) === null) {
            return null;
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $methodName = $method->getName();
            $reflectionMethod = new ReflectionMethod($objectName, $methodName);
            $methodReader = $this->getAnnotationReader()->getMethodAnnotation($reflectionMethod, Annotation::class);
            /* @var Annotation $methodReader */
            if ($methodReader !== null) {
                $property = $this->methodToPropertyName($methodName);
                $data = $methodReader->convert($reflectionMethod->invoke($object));

                if ($filter !== null and !in_array($property, $filter) and !array_key_exists($property, $filter)) {
                    continue;
                }

                if ($methodReader instanceof Object) {
                    if ($this->finalLevel($level) === true) {
                        continue;
                    }

                    $objectFilter = isset($filter[$property]) ? $filter[$property] : null;
                    $results[$property] = $this->map($data, $objectFilter, ($level - 1));
                } else {
                    $results[$property] = $data;
                }
            }
        }

        return $results;
    }

    /**
     * @param $object
     * @return string
     */
    private function getClassName($object)
    {
        return get_class($object);
    }

    /**
     * @param $methodName
     * @return string
     * @throws InvalidGetterNameException
     */
    private function methodToPropertyName($methodName)
    {
        $prefixes = ['get', 'can', 'is', 'has'];
        foreach ($prefixes as $prefix) {
            $prefixLength = strlen($prefix);
            if ($prefix === substr($methodName, 0, $prefixLength)) {
                return lcfirst(substr($methodName, $prefixLength));
            }
        }

        throw new InvalidGetterNameException($methodName, $prefixes);
    }

    /**
     * @param int|null $level
     * @return bool
     */
    private function finalLevel($level)
    {
        if ((int)$level === 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $data
     * @param array $filter
     * @param int $level
     * @return array|null
     */
    public function map($data, array $filter = null, $level = 0)
    {
        $results = [];
        if (is_array($data) or $data instanceof ODMCollection or $data instanceof ORMCollection) {
            foreach ($data as $array) {
                $results[] = $this->map($array, $filter, $level);
            }
        } elseif (is_object($data)) {
            $results = $this->objectMapper($data, $filter, $level);
        }

        return (count($results)) ? $results : null;
    }
}
