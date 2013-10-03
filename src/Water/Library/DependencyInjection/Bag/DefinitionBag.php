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

/**
 * Class DefinitionBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class DefinitionBag extends StronglyTypedBag
{
    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new ClassType('\Water\Library\DependencyInjection\Definition'), $input);
    }
}