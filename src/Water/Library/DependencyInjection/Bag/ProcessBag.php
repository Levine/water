<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:40
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\InterfaceType;
use Water\Library\Bag\Type\TypeInterface;

/**
 * Class ProcessBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ProcessBag extends StronglyTypedBag
{
    /**
     * {@inheritdoc}
     */
    public function __construct(TypeInterface $type = null, array $input = array())
    {
        $type = ($type === null)
              ? new InterfaceType('\Water\Library\DependencyInjection\Compiler\Process\ProcessInterface')
              : $type;
        parent::__construct($type, $input);
    }
}