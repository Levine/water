<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 17:01
 */
namespace Water\Framework\Tests;
use Water\Framework\Tests\Resource\KernelForTestInvalidModule;
use Water\Framework\Tests\Resource\KernelForTests;

/**
 * Class KernelTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class KernelTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testConstruct()
    {
        $kernel = new KernelForTests();

        $this->assertEquals('dev', $kernel->getEnvironment());
        $this->assertEquals(__DIR__ . '/Resource', $kernel->getContainer()->getParameter('kernel_dir'));
        $this->assertInstanceOf('\Water\Library\DependencyInjection\ContainerInterface', $kernel->getContainer());
        $this->assertEquals('value', $kernel->getContainer()->getParameter('test'));
    }

    public function testInvalidModule()
    {
        $this->setExpectedException('\Water\Framework\Exception\InvalidModuleException');
        $kernel = new KernelForTestInvalidModule();
    }
}
