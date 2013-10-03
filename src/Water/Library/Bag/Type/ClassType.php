<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 15:41
 */
namespace Water\Library\Bag\Type;

use Water\Library\Bag\Exception\InvalidArgumentException;

/**
 * Class ClassType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ClassType implements TypeInterface
{
    /**
     * @var string
     */
    protected $type = '';

    /**
     * Constructor.
     *
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    public function __construct($type)
    {
        if (is_object($type)) {
            $type = get_class($type);
        } elseif (is_string($type)){
            if (!class_exists($type, true)) {
                throw new InvalidArgumentException(sprintf(
                    'The type "%s" not exists.',
                    $type
                ));
            }
        } else {
            throw new InvalidArgumentException(sprintf(
                'The type need to be string or object, "%s" given.',
                gettype($type)
            ));
        }
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_a($value, $this->getType());
    }
}