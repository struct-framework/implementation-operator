<?php

declare(strict_types=1);

namespace Struct\Operator;

use Struct\Contracts\Operator\ComparableInterface;
use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SignChangeInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Contracts\SerializableToInt;
use Struct\Contracts\SerializableToString;
use Struct\Operator\Internal\Calculate;
use Struct\Operator\Internal\Compare;
use UnitEnum;

final class O
{
    public static function increment(int|IncrementableInterface &$object): void
    {
        Calculate::increment($object);
    }

    public static function decrement(int|IncrementableInterface &$object): void
    {
        Calculate::decrement($object);
    }

    /**
     * @template T of SumInterface
     * @param array<T> $summandList
     * @return T
     */

    /**
     * @template T of int|float|SumInterface
     * @param array<T> $summandList
     * @return T
     */
    public static function sum(array $summandList): int|float|SumInterface
    {
        return Calculate::sum($summandList);
    }

    /**
     * @template T of int|float|SumInterface
     * @param T $summand01
     * @param T $summand02
     * @return T
     */
    public static function add(
        int|float|SumInterface $summand01,
        int|float|SumInterface $summand02
    ): int|float|SumInterface {
        return Calculate::add($summand01, $summand02);
    }

    /**
     * @template T of int|float|(SumInterface&SignChangeInterface)
     * @param T $left
     * @param T $right
     * @return T
     */
    public static function sub(
        int|float|(SumInterface&SignChangeInterface) $left,
        int|float|(SumInterface&SignChangeInterface) $right
    ): int|float|(SumInterface&SignChangeInterface) {
        return Calculate::sub($left, $right);
    }

    /**
     * @template T of int|float|(SumInterface&SignChangeInterface)
     * @param T $left
     * @return T
     */
    public static function singChange(
        int|float|SignChangeInterface $left,
    ): int|float|SignChangeInterface {
        return Calculate::singChange($left);
    }

    public static function equals(
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $right
    ): bool {
        return Compare::equals($left, $right);
    }

    public static function notEquals(
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|UnitEnum|ComparableInterface|SerializableToString|SerializableToInt $right
    ): bool {
        return Compare::notEquals($left, $right);
    }

    public static function lessThan(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        return Compare::lessThan($left, $right);
    }

    public static function greaterThan(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        return Compare::greaterThan($left, $right);
    }

    public static function lessThanOrEquals(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        return Compare::lessThanOrEquals($left, $right);
    }

    public static function greaterThanOrEquals(
        int|float|ComparableInterface|SerializableToInt $left,
        int|float|ComparableInterface|SerializableToInt $right
    ): bool {
        return Compare::greaterThanOrEquals($left, $right);
    }
}
