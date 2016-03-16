<?php

namespace WW\Gastro\ApiBundle\Types;

class SexType extends EnumType
{
    const NAME = 'sex';

    const MALE   = 'male';
    const FEMALE = 'female';

    protected $valueToString = [
        1 => self::MALE,
        2 => self::FEMALE,
    ];

    protected $stringToValue = [
        self::MALE   => 1,
        self::FEMALE => 2
    ];


}