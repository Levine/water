<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 14:37
 */
namespace Water\Library\Bag\Type;

/**
 * Class StringType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class StringType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'String';
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_string($value);
    }
}