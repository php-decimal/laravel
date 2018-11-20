<?php
/**
 * Global Laravel helpers.
 */
use Decimal\Decimal;

if (!function_exists("decimal")) {
    /**
     * @param string|int|\Decimal\Decimal $value
     * @param int                         $precision
     *
     * @return \Decimal\Decimal The decimal value of $value, parsed to $precision.
     */
    function decimal($value, int $precision = Decimal::DEFAULT_PRECISION): Decimal
    {
        return new Decimal($value, $precision);
    }
}

if (!function_exists("is_decimal")) {
    /**
     * @return bool TRUE if the given value is a decimal, FALSE otherwise.
     */
    function is_decimal($value): bool
    {
        return $value instanceof Decimal;
    }
}

if (!function_exists("decimal_sum")) {
    /**
     * @return \Decimal\Decimal The sum of all given values, calculated to $precision.
     */
    function decimal_sum($values, int $precision = Decimal::DEFAULT_PRECISION): Decimal
    {
        return Decimal::sum($values, $precision);
    }
}

if (!function_exists("decimal_avg")) {
    /**
     * @return \Decimal\Decimal The average of all given values, calculated to $precision.
     */
    function decimal_avg($values, int $precision = Decimal::DEFAULT_PRECISION): Decimal
    {
        return Decimal::avg($values, $precision);
    }
}
