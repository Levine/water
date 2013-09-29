<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 17:07
 */
namespace Water\Framework\Tests\Resource;

use Water\Framework\Kernel\Kernel;
use Water\Framework\Tests\Resource\Module\TestModule;

/**
 * Class KernelForTests
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class KernelForTests extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerModules()
    {
        return array(
            new TestModule(),
        );
    }
}