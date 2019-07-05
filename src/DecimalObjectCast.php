<?php
namespace Decimal;

/**
 * This trait should be added to model classes that use decimal attributes.
 *
 * Laravel supports attribute casting when preparing queries. By default, the
 * "decimal" cast uses `number_format`, but we can utilize the `toFixed` method
 * provided by Decimal\Decimal to prepare the value.
 *
 * This trait does not provide a cast from string to Decimal; this should be
 * done manually using an accessor like `getPriceAttribute`, which should return
 * a new Decimal\Decimal using the precision of the column in the database.
 */
trait DecimalObjectCast
{
    /**
     * Return a decimal as string to be written to the database.
     *
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::asDecimal
     *
     * @param  Decimal  $value
     * @param  int      $decimals
     *
     * @return \Decimal\Decimal
     */
    protected function asDecimal($value, $decimals)
    {
        assert($value instanceof Decimal);
        
        return $value->toFixed($decimals, $commas = false, PHP_ROUND_HALF_UP);
    }
}
