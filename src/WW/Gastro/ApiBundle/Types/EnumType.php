<?php

namespace WW\Gastro\ApiBundle\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumType extends Type
{
    const NAME = '';

    protected $valueToString = [

    ];

    protected $stringToValue = [

    ];

    /**
     * @param array $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'INT';
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = intval($value);

        if (!isset($this->valueToString[$value])) {
            return '';
        }
        return $this->valueToString[$value];
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!isset($this->stringToValue[$value])) {
            return 0;
        }
        return $this->stringToValue[$value];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}