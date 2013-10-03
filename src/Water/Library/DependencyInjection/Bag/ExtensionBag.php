<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 13:44
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\InterfaceType;

/**
 * Class ExtensionBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ExtensionBag extends StronglyTypedBag
{
    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new InterfaceType('\Water\Library\DependencyInjection\Extension\ExtensionInterface'), $input);
    }
}