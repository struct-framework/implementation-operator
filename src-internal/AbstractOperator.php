<?php

declare(strict_types=1);

namespace Struct\Operator\Internal;

use Struct\Exception\Operator\DataTypeException;

/**
 * @internal
 */
abstract class AbstractOperator
{
    protected static function checkType(mixed $left, mixed $right): void
    {
        $leftType = self::readType($left);
        $rightType = self::readType($right);
        if ($leftType !== $rightType) {
            throw new DataTypeException('The data type of $left <' . $leftType . '> and $right <' . $rightType . '> must be same', 1707723361);
        }
    }

    protected static function readType(mixed $value): string
    {
        $type = gettype($value);
        if (is_object($value) === true) {
            return $value::class;
        }
        return $type;
    }
}
