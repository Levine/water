<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 15:50
 */
namespace Water\Library\Bag\Type;

use Water\Library\Bag\Exception\InvalidArgumentException;

/**
 * Class InterfaceType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InterfaceType extends ObjectType
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
        if (!interface_exists($type, true)) {
            throw new InvalidArgumentException(sprintf(
                'The type "%s" not exists.',
                $type
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
}