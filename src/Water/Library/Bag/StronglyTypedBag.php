<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 14:31
 */
namespace Water\Library\Bag;

use Water\Library\Bag\Exception\InvalidArgumentException;
use Water\Library\Bag\Type\TypeInterface;

/**
 * Class StronglyTypedBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class StronglyTypedBag extends SimpleBag
{
    /**
     * @var TypeInterface
     */
    protected $type = null;

    /**
     * Constructor.
     *
     * @param TypeInterface $type
     * @param array         $input
     */
    public function __construct(TypeInterface $type, array $input = array())
    {
        $this->type = $type;

        foreach ($input as $value) {
            $this->validate($value);
        }

        parent::__construct($input);
    }

    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    public function validate($value)
    {
        if (!$this->type->valid($value)) {
            throw new InvalidArgumentException(sprintf(
                'It is a Strongly Typed Bag, pass only "%s" values',
                $this->type->getType()
            ));
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function append($value)
    {
        $this->validate($value);

        parent::append($value);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function set($index, $value)
    {
        $this->validate($value);

        return parent::set($index, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function merge(array $input)
    {
        foreach ($input as $value) {
            $this->validate($value);
        }

        parent::merge($input);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function fromArray(array $input)
    {
        foreach ($input as $value) {
            $this->validate($value);
        }

        return parent::fromArray($input);
    }
}