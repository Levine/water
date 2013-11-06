<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 22:24
 */
namespace Water\Framework\Kernel\Tests\Resource;

use Water\Framework\Kernel\Kernel;
use Water\Framework\Kernel\Tests\Resource\Module\TestModule;

/**
 * Class TestKernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestKernel extends Kernel
{
    public function registerModules()
    {
        return array(
            new TestModule(),
        );
    }
}