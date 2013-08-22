<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 22:53
 */
namespace Water\Library\Bag;

use \ArrayAccess;
use \Countable;
use \IteratorAggregate;
use \Serializable;

/**
 * Interface BagInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface BagInterface extends ArrayAccess, Countable, IteratorAggregate, Serializable
{
    const DEFAULT_VALUE = null;

    /**
     * Returns the value of a specified index, if the index not exists return a default value.
     *
     * @param mixed $index
     * @param mixed $default
     * @return mixed
     */
    public function get($index, $default = self::DEFAULT_VALUE);

    /**
     * Define the value of a specified index to value.
     *
     * @param mixed $index
     * @param mixed $value
     * @return BagInterface
     */
    public function set($index, $value);

    /**
     * Returns a array copy of the BagInterface.
     *
     * @return array
     */
    public function toArray();

    /**
     * Returns a query string from BagInterface.
     *
     * @return string
     */
    public function toString();

    /**
     * @see BagInterface::toString()
     */
    public function __toString();
}
