<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:40
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;
use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ClassType;

/**
 * Class ProcessBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ProcessBag extends StronglyTypedBag
{
    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new ClassType('\Water\Library\DependencyInjection\Compiler\Process\ProcessInterface'), $input);
    }
}