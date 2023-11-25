<?php

declare(strict_types=1);

namespace Struct\Operator;

use Struct\Contracts\Operator\ComparableInterface;
use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SubInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Enum\Operator\Comparison;
use Struct\Exception\Operator\DataTypeException;

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
