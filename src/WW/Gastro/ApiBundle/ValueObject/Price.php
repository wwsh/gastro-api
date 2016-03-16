<?php

namespace WW\Gastro\ApiBundle\ValueObject;

/**
 * Class Price
 * @package WW\Gastro\ApiBundle\ValueObject
 */
class Price
{
    /**
     * Default current of each price.
     */
    const DEFAULT_CURRENCY = 'PLN';

    /**
     * @var integer
     */
    private $value;

    /**
     * @var string
     */
    private $currency;

    /**
     * The constructor.
     *
     * @param $value Price amount in bigint format (i.e.: 9.98 = 998).
     * @param string $currency Currency string value.
     */
    public function __construct($value, $currency = self::DEFAULT_CURRENCY)
    {
        $this->value    = $value;
        $this->currency = $currency;
    }

    /**
     * Getting the amount.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Getting the currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }


}
