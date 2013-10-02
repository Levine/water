<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 13:44
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\IntegerType;
use Water\Library\Bag\Type\TypeInterface;

/**
 * Class ExtensionBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ExtensionBag extends StronglyTypedBag
{
    /**
     * {@inheritdoc}
     */
    public function __construct(TypeInterface $type = null, array $input = array())
    {
        $type = ($type === null)
              ? new IntegerType('\Water\Library\DependencyInjection\Extension\ExtensionInterface')
              : $type;
        parent::__construct($type, $input);
    }
}