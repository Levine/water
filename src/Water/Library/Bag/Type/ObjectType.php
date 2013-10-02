<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 14:38
 */
namespace Water\Library\Bag\Type;

/**
 * Class ObjectType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ObjectType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'Object';
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_object($value);
    }
}