<?php

declare(strict_types=1);

namespace Struct\Operator;

use Struct\Contracts\Operator\IncrementableInterface;
use Struct\Contracts\Operator\SubInterface;
use Struct\Contracts\Operator\SumInterface;
use Struct\Exception\Operator\DataTypeException;

final class Calculate
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
}
