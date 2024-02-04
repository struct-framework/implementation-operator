<?php

declare(strict_types=1);

namespace Struct\Operator;

use Exception\Unexpected\UnexpectedException;
use Struct\Contracts\Operator\ComparableInterface;
use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SubInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Contracts\SerializableToInt;
use Struct\Enum\Operator\Comparison;
use Struct\Exception\Operator\CompareException;
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

    protected static function _compare(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): Comparison
    {
        if ($left::class !== $right::class) {
            throw new CompareException('The objects to compare must be of same type <' . $left::class . '> and <' . $right::class . '> given', 1707056159);
        }

        if (
            is_a($left, ComparableInterface::class) === true &&
            is_a($right, ComparableInterface::class) === true
        ) {
            $compare = $left->compare($right);
            return $compare;
        }

        if (
            is_a($left, SerializableToInt::class) !== true ||
            is_a($right, SerializableToInt::class) !== true
        ) {
            throw new UnexpectedException(1707056225);
        }

        $leftInt = $left->serializeToInt();
        $rightInt = $right->serializeToInt();
        if ($leftInt > $rightInt) {
            return Comparison::greaterThan;
        }

        if ($leftInt < $rightInt) {
            return Comparison::lessThan;
        }
        return Comparison::equal;
    }

    public static function equals(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
    {
        $compare = self::_compare($left, $right);
        if ($compare === Comparison::equal) {
            return true;
        }
        return false;
    }

    public static function notEquals(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
    {
        return self::equals($left, $right) === false;
    }

    public static function lessThan(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
    {
        $compare = self::_compare($left, $right);
        if ($compare === Comparison::lessThan) {
            return true;
        }
        return false;
    }

    public static function greaterThan(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
    {
        $compare = self::_compare($left, $right);
        if ($compare === Comparison::greaterThan) {
            return true;
        }
        return false;
    }

    public static function lessThanOrEquals(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
    {
        if (self::equals($left, $right) === true) {
            return true;
        }
        if (self::lessThan($left, $right) === true) {
            return true;
        }
        return false;
    }

    public static function greaterThanOrEquals(ComparableInterface|SerializableToInt $left, ComparableInterface|SerializableToInt $right): bool
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
