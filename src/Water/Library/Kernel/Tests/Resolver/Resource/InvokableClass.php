<?php
/**
 * User: Ivan C. Sanches
 * Date: 23/09/13
 * Time: 09:07
 */
namespace Water\Library\Kernel\Tests\Resolver\Resource;

/**
 * Class InvokableClass
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvokableClass
{
    public function __invoke()
    {
        return true;
    }
}