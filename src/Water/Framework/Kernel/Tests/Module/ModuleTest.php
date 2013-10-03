<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 23:01
 */
namespace Water\Framework\Kernel\Tests\Module;

use Water\Framework\Kernel\Tests\Module\Resource\TestModule;
use Water\Framework\Kernel\Tests\Module\Resource\TestNotExtendModule;

/**
 * Class ModuleTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testModule()
    {
        $module = new TestModule();

        $this->assertEquals('TestModule', $module->getShortName());
        $this->assertEquals('Water\Framework\Kernel\Tests\Module\Resource', $module->getNamespaceName());
        $this->assertEquals('Water\Framework\Kernel\Tests\Module\Resource\TestModule', $module->getName());
        $this->assertEquals(__DIR__ . '/Resource/TestModule.php', $module->getFileName());
        $this->assertEquals(__DIR__ . '/Resource', $module->getPath());
        $this->assertInstanceOf('\ReflectionClass', $module->getReflection());
    }

    public function testExtension()
    {
        $module = new TestModule();

        $this->assertInstanceOf('\Water\Library\DependencyInjection\Extension\ExtensionInterface', $module->getExtension());

        $module = new TestNotExtendModule();

        $this->assertNull($module->getExtension());
    }
}
