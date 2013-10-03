<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 22:10
 */
namespace Water\Framework\Kernel\Bag;

use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ClassType;

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
        parent::__construct(new ClassType('\Water\Framework\Kernel\Module\ModuleInterface'), $input);
    }
}