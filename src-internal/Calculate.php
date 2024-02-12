<?php

declare(strict_types=1);

namespace Struct\Operator\Internal;

use Exception\Unexpected\UnexpectedException;
use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SignChangeInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Exception\Operator\DataTypeException;

/**
 * @internal
 */
final class Calculate extends AbstractOperator
{
    public static function increment(int|IncrementableInterface &$object): void
    {
        if (is_int($object) === true) {
            $object++;
            return;
        }
        $object->increment();
    }

    public static function decrement(int|IncrementableInterface &$object): void
    {
        if (is_int($object) === true) {
            $object--;
            return;
        }
        $object->decrement();
    }

    /**
     * @template T of int|float|SumInterface
     * @param array<T> $summandList
     * @return T
     */
    public static function sum(array $summandList): int|float|SumInterface
    {
        if (count($summandList) === 0) {
            throw new DataTypeException('There must be at least one summand', 1696344860);
        }
        $firstValue = $summandList[0];
        if (is_object($firstValue) === true) {
            /** @var array<SumInterface> $summandListToWork */
            $summandListToWork = $summandList;
            /** @var class-string<SumInterface> $className */
            $className = $firstValue::class;
            /** @var SumInterface $result */
            $result = $className::sum($summandListToWork);
            return $result;
        }
        $result = 0;
        foreach ($summandList as $value) {
            $result += $value;
        }
        return $result;
    }

    /**
     * @template T of int|float|SumInterface
     * @param T $left
     * @param T $right
     * @return T
     */
    public static function add(
        int|float|SumInterface $left,
        int|float|SumInterface $right
    ): int|float|SumInterface {
        self::checkType($left, $right);
        if (is_object($left) === true && is_object($right) === true) {
            if (
                is_a($left, SumInterface::class) === true &&
                is_a($right, SumInterface::class) === true
            ) {
                /** @var class-string<SumInterface> $className */
                $className = $left::class;
                /** @var SumInterface $result */
                $result = $className::sum([$left, $right]);
                return $result;
            }
            throw new UnexpectedException(1707732346);
        }
        if (is_int($left) && is_int($right)) {
            return $left + $right;
        }
        if (is_float($left) && is_float($right)) {
            return $left + $right;
        }
        throw new UnexpectedException(1707732346);
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
        $singChangeRight = self::singChange($right);
        return self::add($left, $singChangeRight);
    }

    /**
     * @template T of int|float|SignChangeInterface
     * @param T $left
     * @return T
     */
    public static function singChange(
        int|float|SignChangeInterface $left,
    ): int|float|SignChangeInterface {
        if (is_object($left) === true) {
            if (is_a($left, SignChangeInterface::class) === true) {
                /** @var class-string<SignChangeInterface> $className */
                $className = $left::class;
                /** @var SignChangeInterface $result */
                $result = $className::signChange($left);
                return $result;
            }
            throw new UnexpectedException(1707733001);
        }
        if (is_int($left) === true) {
            return $left * -1;
        }
        return $left * -1;
    }
}
