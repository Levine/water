<?php
/**
 * User: Ivan C. Sanches
 * Date: 06/11/13
 * Time: 15:42
 */
namespace Water\Module\TeapotModule\Tests\EventListener;
use Water\Library\Http\Request;
use Water\Module\TeapotModule\EventListener\TemplateListener;

/**
 * Class TemplateListenerTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateListenerTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getFilterControllerEventMockBuilder()
    {
        return $this->getMockBuilder('\Water\Library\Kernel\Event\FilterControllerEvent');
    }

    private function getResponseFromControllerResultEventMockBuilder()
    {
        return $this->getMockBuilder('\Water\Library\Kernel\Event\ResponseFromControllerResultEvent');
    }

    private function getKernelMock()
    {
        return $this->getMockForAbstractClass('\Water\Framework\Kernel\Kernel');
    }

    private function getContainerMockBuilder()
    {
        return $this->getMockBuilder('\Water\Library\DependencyInjection\Container');
    }

    private function getModuleBagMockBuilder()
    {
        return $this->getMockBuilder('\Water\Framework\Kernel\Bag\ModuleBag');
    }

    private function getModuleMockBuilder()
    {
        return $this->getMockBuilder('\Water\Framework\Kernel\Module\Module');
    }

    private function getFilterControllerEventMock(Request $request, $controller)
    {
        return $this->getFilterControllerEventMockBuilder()
                    ->setConstructorArgs(array($this->getKernelMock(), $request, $controller))
                    ->getMock();
    }

    private function getContainerMock(array $services)
    {
        $container = $this->getContainerMockBuilder()->getMock();
        $container->setServices($services);
        return $container;
    }

    private function getModuleBagMock(array $modules)
    {
        return $this->getModuleBagMockBuilder()
                    ->setConstructorArgs(array($modules))
                    ->getMock();
    }

    private function getModuleMock($namespace, $shortName)
    {
        $module = $this->getModuleMockBuilder()
                       ->setMethods(array('getNamespaceName', 'getShortName'))
                       ->getMock();
        $module->expects($this->any())
               ->method('getNamespaceName')
               ->will($this->returnValue($namespace));
        $module->expects($this->any())
               ->method('getShortName')
               ->will($this->returnValue($shortName));

        return $module;
    }

    public function testOnKernelController()
    {
        $this->markTestIncomplete();

        $modules = $this->getModuleBagMock(array(
            'PombaCorpTest' => $this->getModuleMock('PombaCorp\Test\PombaCorpTestModule', 'PombaCorpTestModule')
        ));
        $services = array(
            'modules' => $modules
        );
        $listener = new TemplateListener($this->getContainerMock($services));
    }
}
 