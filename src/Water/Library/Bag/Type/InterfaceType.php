<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 15:50
 */
namespace Water\Library\Bag\Type;

/**
 * Class InterfaceType
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InterfaceType implements TypeInterface
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
     * @throws \InvalidArgumentException
     */
    public function __construct($type)
    {
        if (!interface_exists($type, true)) {
            throw new \InvalidArgumentException(sprintf(
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
    /**
     * {@inheritdoc}
     */
    public function valid($value)
    {
        return is_a($value, $this->getType());
    }

}