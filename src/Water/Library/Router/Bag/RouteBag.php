<?php
/**
 * User: Ivan C. Sanches
 * Date: 12/11/13
 * Time: 16:28
 */
namespace Water\Library\Router\Bag;

use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ClassType;

/**
 * Class RouteBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteBag extends StronglyTypedBag
{
    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new ClassType('\Water\Library\Router\Route'), $input);
    }
} 