<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:33
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ClassType;
use Water\Library\Bag\Type\TypeInterface;

/**
 * Class DefinitionBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class DefinitionBag extends StronglyTypedBag
{
    /**
     * {@inheritdoc}
     */
    public function __construct(TypeInterface $type = null, array $input = array())
    {
        $type = ($type === null)
              ? new ClassType('\Water\Library\DependencyInjection\Definition')
              : $type;
        parent::__construct($type, $input);
    }
}