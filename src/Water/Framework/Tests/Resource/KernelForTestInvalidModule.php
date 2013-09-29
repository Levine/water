<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 17:33
 */
namespace Water\Framework\Tests\Resource;

use Water\Framework\Kernel\Kernel;
use Water\Framework\Tests\Resource\Module\TestModule;
use Water\Framework\Tests\Resource\Module\TestNotModule;

/**
 * Class KernelForTestInvalidModule
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class KernelForTestInvalidModule extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerModules()
    {
        return array(
            new TestModule(),
            new TestNotModule(),
        );
    }
}