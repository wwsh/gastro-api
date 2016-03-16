<?php

namespace WW\Gastro\ApiBundle\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use WW\Gastro\ApiBundle\ValueObject\Price;

/**
 * Class PriceType
 * @package WW\Gastro\ApiBundle\Types
 */
class PriceType extends Type
{
    const NAME = 'price';

    /**
     * Getting name.
     *
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(
        array $fieldDeclaration,
        AbstractPlatform $platform
    ) {
        return 'BIGINT';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return Price
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Price($value);
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Price) {
            $value = $value->getValue();
        }

        return $value;
    }

}
