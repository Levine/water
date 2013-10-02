<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 16:46
 */
namespace Water\Library\Bag\Type;

/**
 * Class BooleanType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class BooleanType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'Boolean';
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_bool($value);
    }
}