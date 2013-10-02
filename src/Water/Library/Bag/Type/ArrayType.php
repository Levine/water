<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:47
 */
namespace Water\Library\Bag\Type;

/**
 * Class ArrayType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ArrayType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'Array';
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_array($value);
    }
}