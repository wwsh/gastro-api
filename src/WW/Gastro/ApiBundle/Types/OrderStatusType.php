<?php

namespace WW\Gastro\ApiBundle\Types;


class OrderStatusType extends EnumType
{
    const NAME = 'orderstatus';

    const REQUESTED = 'requested';
    const PROCESSED = 'processed';
    const READY     = 'ready';
    const CANCELLED = 'cancelled';
    const STORNED   = 'storned';
    const COMPLETE  = 'complete';

    protected $valueToString = [
        301 => self::REQUESTED,
        302 => self::PROCESSED,
        303 => self::READY,
        304 => self::CANCELLED,
        305 => self::STORNED,
        306 => self::COMPLETE
    ];

    protected $stringToValue = [
        self::REQUESTED => 301,
        self::PROCESSED => 302,
        self::READY     => 303,
        self::CANCELLED => 304,
        self::STORNED   => 305,
        self::COMPLETE  => 306,
    ];


}