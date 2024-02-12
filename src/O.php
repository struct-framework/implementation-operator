<?php

declare(strict_types=1);

namespace Struct\Operator;

use Struct\Contracts\Operator\ComparableInterface;
use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SubInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Contracts\SerializableToInt;
use Struct\Contracts\SerializableToString;
use Struct\Exception\Operator\DataTypeException;
use Struct\Operator\Internal\Compare;

final class O
{
    public static function increment(IncrementableInterface $object): void
    {
        $object->increment();
    }

    public static function decrement(IncrementableInterface $object): void
    {
        $object->decrement();
    }

    /**
     * @template T of SumInterface
     * @param array<T> $summandList
     * @return T
     */
    public static function sum(array $summandList): SumInterface
    {
        if (count($summandList) === 0) {
            throw new DataTypeException('There must be at least one summand', 1696344860);
        }
        $summand01 = $summandList[0];
        /** @var class-string<SumInterface> $className */
        $className = $summand01::class;
        $result = $className::sum($summandList);
        return $result;
    }

    /**
     * @template T of SumInterface
     * @param T $summand01
     * @param T $summand02
     * @return T
     */
    public static function add(SumInterface $summand01, SumInterface $summand02): SumInterface
    {
        /** @var class-string<SumInterface> $className */
        $className = $summand01::class;
        $result = $className::sum([$summand01, $summand02]);
        return $result;
    }

    /**
     * @template T of SubInterface
     * @param T $minuend
     * @param T $subtrahend
     * @return T
     */
    public static function sub(SubInterface $minuend, SubInterface $subtrahend): SubInterface
    {
        /** @var class-string<SubInterface> $className */
        $className = $minuend::class;
        $result = $className::sub($minuend, $subtrahend);
        return $result;
    }

    public static function equals(
        string|int|float|bool|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|ComparableInterface|SerializableToString|SerializableToInt $right
    ): bool {
        return Compare::equals($left, $right);
    }

    public static function notEquals(
        string|int|float|bool|ComparableInterface|SerializableToString|SerializableToInt $left,
        string|int|float|bool|ComparableInterface|SerializableToString|SerializableToInt $right
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
