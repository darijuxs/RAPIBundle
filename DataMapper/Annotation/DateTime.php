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
     * @var string
     */
    private $format = "Y-m-d H:i:s";

    /**
     * Decide if return DateTime object or string. By default return DateTime object
     *
     * @var bool
     */
    private $object = true;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options["format"])) {
            $this->format = $options["format"];
        }

        if (isset($options["object"])) {
            $this->object = $options["object"];
        }
    }

    /**
     * @param $value
     * @return null|string|GlobalDateTime
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

        if ($this->object === false) {
            return $value->format($this->format);
        }

        return $value;
    }
}
