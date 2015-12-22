<?php

namespace RAPIBundle\DataMapper\Annotation;

use DateTime as GlobalDateTime;
use RAPIBundle\DataMapper\Exception\InvalidTypeException;

/**
 * Class Time
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Time extends Annotation
{
    /**
     * @var string
     */
    private $format = "H:i:s";

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options["format"])) {
            $this->format = $options["format"];
        }
    }

    /**
     * @param $value
     * @return null|string
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

        return $value->format($this->format);
    }
}
