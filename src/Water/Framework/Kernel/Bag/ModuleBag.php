<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 22:10
 */
namespace Water\Framework\Kernel\Bag;

use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ClassType;
use Water\Library\Bag\Type\InterfaceType;

/**
 * Class ModuleBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ModuleBag extends StronglyTypedBag
{
    /**
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new InterfaceType('\Water\Framework\Kernel\Module\ModuleInterface'), $input);
    }
}