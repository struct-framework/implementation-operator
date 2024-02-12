<?php

declare(strict_types=1);

namespace Struct\Operator\Internal;

use Exception\Unexpected\UnexpectedException;
use Struct\Contracts\Operator\ComparableInterface;
use Struct\Contracts\SerializableToInt;
use Struct\Contracts\SerializableToString;
use Struct\Enum\Operator\Comparison;
use Struct\Exception\Operator\CompareException;
use UnitEnum;

/**
 * @internal
 */
final class Compare extends AbstractOperator
{
    public static function equals(
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $right
    ): bool {
        self::checkType($left, $right);

        if (is_object($left) === true && is_object($right) === true) {
            if (
                is_a($left, UnitEnum::class) === true &&
                is_a($right, UnitEnum::class) === true
            ) {
                return $left === $right;
            }
            if (
                is_a($left, ComparableInterface::class) === true &&
                is_a($right, ComparableInterface::class) === true
            ) {
                return $left->compare($right) === Comparison::equal;
            }
            if (
                is_a($left, SerializableToString::class) === true &&
                is_a($right, SerializableToString::class) === true
            ) {
                return $left->serializeToString() === $right->serializeToString();
            }
            if (
                is_a($left, SerializableToInt::class) === true &&
                is_a($right, SerializableToInt::class) === true
            ) {
                return $left->serializeToInt() === $right->serializeToInt();
            }
            throw new UnexpectedException(1707727033);
        }
        return $left === $right;
    }

    public static function notEquals(
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $right
    ): bool {
        return self::equals($left, $right) === false;
    }

    public static function lessThan(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        self::checkType($left, $right);
        if (is_object($left) === true && is_object($right) === true) {
            if (
                is_a($left, ComparableInterface::class) === true &&
                is_a($right, ComparableInterface::class) === true
            ) {
                $compareResult = $left->compare($right);
                if ($compareResult === Comparison::notEqual) {
                    throw new CompareException('At less than the compare function must not return <Comparison::notEqual>', 1707724028);
                }
                return $compareResult === Comparison::lessThan;
            }
            if (
                is_a($left, SerializableToInt::class) === true &&
                is_a($right, SerializableToInt::class) === true
            ) {
                return $left->serializeToInt() < $right->serializeToInt();
            }
            throw new UnexpectedException(1707726981);
        }
        return $left < $right;
    }

    public static function greaterThan(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        self::checkType($left, $right);
        if (is_object($left) === true && is_object($right) === true) {
            if (
                is_a($left, ComparableInterface::class, true) === true &&
                is_a($right, ComparableInterface::class, true) === true
            ) {
                $compareResult = $left->compare($right);
                if ($compareResult === Comparison::notEqual) {
                    throw new CompareException('At less than the compare function must not return <Comparison::notEqual>', 1707724028);
                }
                return $compareResult === Comparison::greaterThan;
            }
            if (
                is_a($left, SerializableToInt::class, true) === true &&
                is_a($right, SerializableToInt::class, true) === true
            ) {
                return $left->serializeToInt() > $right->serializeToInt();
            }
            throw new UnexpectedException(1707726858);
        }

        return $left > $right;
    }

    public static function lessThanOrEquals(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        if (self::equals($left, $right) === true) {
            return true;
        }
        if (self::lessThan($left, $right) === true) {
            return true;
        }
        return false;
    }

    public static function greaterThanOrEquals(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        if (self::equals($left, $right) === true) {
            return true;
        }
        if (self::greaterThan($left, $right) === true) {
            return true;
        }
        return false;
    }
}
