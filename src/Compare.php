<?php

declare(strict_types=1);

namespace Struct\Operator;

use Struct\Contracts\Operator\ComparableInterface;
use Struct\Enum\Operator\Comparison;

/**
 * @deprecated pleas use O instead
 */
final class Compare
{
    public static function equals(ComparableInterface $left, ComparableInterface $right): bool
    {
        $compare = $left->compare($right);
        if ($compare === Comparison::equal) {
            return true;
        }
        return false;
    }

    public static function notEquals(ComparableInterface $left, ComparableInterface $right): bool
    {
        return self::equals($left, $right) === false;
    }

    public static function lessThan(ComparableInterface $left, ComparableInterface $right): bool
    {
        $compare = $left->compare($right);
        if ($compare === Comparison::lessThan) {
            return true;
        }
        return false;
    }

    public static function greaterThan(ComparableInterface $left, ComparableInterface $right): bool
    {
        $compare = $left->compare($right);
        if ($compare === Comparison::greaterThan) {
            return true;
        }
        return false;
    }

    public static function lessThanOrEquals(ComparableInterface $left, ComparableInterface $right): bool
    {
        if (self::equals($left, $right) === true) {
            return true;
        }
        if (self::lessThan($left, $right) === true) {
            return true;
        }
        return false;
    }

    public static function greaterThanOrEquals(ComparableInterface $left, ComparableInterface $right): bool
    {
        if (self::equals($left, $right) === true) {
            return true;
        }
        if (self::greaterThan($left, $right) === true) {
            return true;
        }
        return false;
    }
}
