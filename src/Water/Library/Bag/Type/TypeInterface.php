<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 14:32
 */
namespace Water\Library\Bag\Type;

/**
 * Interface TypeInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface TypeInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return bool
     */
    public function valid($value);
}