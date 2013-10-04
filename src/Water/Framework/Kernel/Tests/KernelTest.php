<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 22:20
 */
namespace Water\Framework\Kernel\Tests;

use Water\Framework\Kernel\Tests\Module\Resource\TestModule;
use Water\Framework\Kernel\Tests\Resource\TestKernel;
use Water\Library\Http\Request;

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

    public function testConstructor()
    {
        $kernel = new TestKernel();

        $this->assertInstanceOf('\Water\Library\DependencyInjection\ContainerBuilderInterface', $kernel->getContainer());

        $modules = $kernel->getModules();
        $this->assertTrue(isset($modules['TestModule']));
    }

    public function testGetHttpKernel()
    {
        $request = Request::create('/');

        $httpKernelMock = $this->getMockBuilder('Water\Library\Kernel\HttpKernel')
                               ->disableOriginalConstructor()
                               ->getMock();

        $container = $this->getMockBuilder('\Water\Library\DependencyInjection\Container')
                          ->disableOriginalConstructor()
                          ->setMethods(array('get'))
                          ->getMock();
        $container->expects($this->any())
                  ->method('get')
                  ->with('http_kernel')
                  ->will($this->returnValue($httpKernelMock));

        $kernel = $this->getMockBuilder('\Water\Framework\Kernel\Tests\Resource\TestKernel')
                       ->disableOriginalConstructor()
                       ->setMethods(array('getContainer'))
                       ->getMock();
        $kernel->expects($this->any())
               ->method('getContainer')
               ->will($this->returnValue($container));

        $kernel->getHttpKernel();
    }

    public function testHandle()
    {
        $request = Request::create('/');

        $httpKernelMock = $this->getMockBuilder('\Water\Library\Kernel\HttpKernel')
            ->setMethods(array('handle'))
            ->disableOriginalConstructor()
            ->getMock();
        $httpKernelMock->expects($this->any())
            ->method('handle')
            ->with($request);

        $kernel = $this->getMockBuilder('\Water\Framework\Kernel\Tests\Resource\TestKernel')
            ->disableOriginalConstructor()
            ->setMethods(array('getModules', 'getHttpKernel'))
            ->getMock();

        $extension = $this->getMock('\Water\Library\DependencyInjection\Extension\ExtensionInterface', array('extend'));
        $extension->expects($this->any())
                  ->method('expend')
                  ->with($this->isInstanceOf('\Water\Library\DependencyInjection\ContainerInterface'));
        $module = $this->getMockBuilder('\Water\Framework\Kernel\Module\Module')
                       ->setMethods(array('getExtension'))
                       ->getMock();
        $module->expects($this->any())
               ->method('getExtension')
               ->will($this->returnValue($extension));

        $kernel->expects($this->any())
               ->method('getModules')
               ->will($this->returnValue(array('module1' => $module)));
        $kernel->expects($this->any())
            ->method('getHttpKernel')
            ->will($this->returnValue($httpKernelMock));

        $kernel->handle($request);
    }
}
