<?php

namespace WW\Gastro\ApiBundle\Types;


class BillStatusType extends EnumType
{
    const NAME = 'billstatus';

    const OPEN      = 'open';
    const PAID      = 'paid';
    const STORNED   = 'storned';
    const CANCELLED = 'cancelled';

    protected $valueToString = [
        201 => self::OPEN,
        202 => self::PAID,
        203 => self::STORNED,
        204 => self::CANCELLED
    ];

    protected $stringToValue = [
        self::OPEN      => 201,
        self::PAID      => 202,
        self::STORNED   => 203,
        self::CANCELLED => 204,
    ];


}