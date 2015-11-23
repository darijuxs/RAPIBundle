<?php

namespace RAPIBundle\DataMapper\Annotation;

use DateTime;
use RAPIBundle\DataMapper\Exception\InvalidTypeException;

/**
 * Class Date
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Date extends Annotation
{
    /**
     * @var string
     */
    private $format = "Y-m-d";

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

        if (!$value instanceof DateTime) {
            throw new InvalidTypeException($value, get_class($this));
        }

        return $value->format($this->format);
    }
}
