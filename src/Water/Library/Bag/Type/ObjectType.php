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
abstract class ObjectType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function getType();

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_a($value, $this->getType());
    }
}