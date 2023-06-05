<?php
namespace Decimal;

/**
 * This trait should be added to model classes that use decimal attributes.
 *
 * Laravel supports attribute casting when preparing queries. By default, the
 * "decimal" cast uses `number_format`, but we can utilize the `toFixed` method
 * provided by Decimal\Decimal to prepare the value.
 *
 * This trait extends the default behavior by allowing the precision and scale
 * of the decimal value to be specified via the attribute's casting definition.
 * For example, `decimal:2:8` would cast the attribute to a Decimal with 2 digits
 * of scale and 8 digits of precision.
 */
trait DecimalObjectCast
{
    /**
     * Cast an attribute to a native PHP type.
     *
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::castAttribute
     *
     * @param string $key
     * @param mixed  $value Raw value
     *
     * @return mixed Transformed value
     */
    public function castAttribute($key, $value)
    {
        if ($value !== null) {
            $casts = $this->getCasts();
            if (array_key_exists($key, $casts)) {
                $castType = $casts[$key];
                if ($this->isDecimalCast($castType)) {
                    $precision = explode(':', $castType)[2] ?? Decimal::DEFAULT_PRECISION;

                    return new Decimal($value, $precision);
                }
            }
        }

        return parent::castAttribute($key, $value);
    }

    /**
     * Set a given attribute on the model.
     *
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::setAttribute
     *
     * @param string $key
     * @param mixed  $value Raw value
     *
     * @return mixed The model
     */
    public function setAttribute($key, $value)
    {
        if ($value !== null) {
            $casts = $this->getCasts();
            if (array_key_exists($key, $casts)) {
                $castType = $casts[$key];
                if ($this->isDecimalCast($castType)) {
                    if (!$value instanceof Decimal) {
                        $value = $this->castAttribute($key, $value);
                    }

                    $decimals = explode(':', $castType)[1];
                    $this->attributes[$key] = $value->toFixed($decimals, false, PHP_ROUND_HALF_UP);

                    return $this;
                }
            }
        }

        return parent::setAttribute($key, $value);
    }
}
