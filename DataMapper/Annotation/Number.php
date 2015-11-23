<?php

namespace RAPIBundle\DataMapper\Annotation;

/**
 * Class Number
 * @package RAPIBundle\DataMapper\Annotation
 * @Annotation
 */
final class Number extends Annotation
{
    /**
     * @var int
     */
    private $decimals = 0;

    /**
     * @var string
     */
    private $separator = '.';

    /**
     * @var string
     */
    private $thousandSeparator = '';

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (isset($options["decimals"])) {
            $this->decimals = $options["decimals"];
        }

        if (isset($options["separator"])) {
            $this->separator = $options["separator"];
        }

        if (isset($options["thousand_separator"])) {
            $this->thousandSeparator = $options["thousand_separator"];
        }
    }

    /**
     * @param $value
     * @return null|string
     */
    public function convert($value)
    {
        if ($value === null) {
            return null;
        }

        return number_format($value, $this->decimals, $this->separator, $this->thousandSeparator);
    }
}
