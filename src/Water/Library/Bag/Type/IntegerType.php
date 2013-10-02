<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 14:34
 */
namespace Water\Library\Bag\Type;

/**
 * Class IntegerType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class IntegerType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'Integer';
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_int($value);
    }
}