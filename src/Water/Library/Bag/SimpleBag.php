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
    public function set($index, $value)
    {
        $this->offsetSet($index, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $input)
    {
        return $this->exchangeArray($input);
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
