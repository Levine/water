<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 22:49
 */
namespace Water\Library\Bag;

use \ArrayObject;

/**
 * Class SimpleBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class SimpleBag extends ArrayObject implements BagInterface
{
    /**
     * Construct a SimpleBag.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct($input, ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * {@inheritdoc}
     */
    public function has($index)
    {
        return parent::offsetExists($index);
    }

    /**
     * Override to the local method.
     */
    public function offsetSet($index, $value)
    {
        $this->set($index, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function set($index, $value)
    {
        parent::offsetSet($index, $value);
        return $this;
    }

    /**
     * Override to the local method.
     */
    public function offsetUnset($index)
    {
        $this->remove($index);
    }

    /**
     * Unset the element specified by index.
     *
     * @param mixed $index
     * @return BagInterface
     */
    public function remove($index)
    {
        parent::offsetUnset($index);
        return true;
    }

    /**
     * Returns the value of a specified index, if the index not exists return a default value.
     *
     * @param mixed $index
     * @return mixed|void
     */
    public function offsetGet($index)
    {
        return $this->get($index);
    }

    /**
     * {@inheritdoc}
     */
    public function get($index, $default = self::DEFAULT_VALUE)
    {
        if ($this->offsetExists($index)) {
            return parent::offsetGet($index);
        }
        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array $input)
    {
        $merge = array_merge((array) $this, $input);
        $this->fromArray($merge);
        return $this;
    }

    /**
     * Override to the local method.
     */
    public function exchangeArray($input)
    {
        return $this->fromArray($input);
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $input)
    {
        return parent::exchangeArray($input);
    }

    /**
     * {@inheritdoc}
     */
    public function fromString($input)
    {
        $array = array();
        parse_str($input, $array);
        return $this->fromArray($array);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return http_build_query($this);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
