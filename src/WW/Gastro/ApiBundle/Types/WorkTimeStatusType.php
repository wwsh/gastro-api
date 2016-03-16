<?php

namespace WW\Gastro\ApiBundle\Types;

/**
 * Class WorkTimeType
 * @package WW\Gastro\ApiBundle\Types
 */
class WorkTimeStatusType extends EnumType
{
    const NAME = 'worktimestatus';

    const WORKING = 'working';
    const CLOSED  = 'closed';
    const PAUSED  = 'paused';

    protected $valueToString = [
        101 => self::WORKING,
        102 => self::CLOSED,
        103 => self::PAUSED,
    ];

    protected $stringToValue = [
        self::WORKING => 101,
        self::CLOSED  => 102,
        self::PAUSED  => 103,
    ];

}