<?php
/**
 * User: Ivan C. Sanches
 * Date: 07/11/13
 * Time: 10:47
 */
namespace Water\Module\TeapotModule\Tests\Template;

use Water\Module\TeapotModule\Template\TemplateFinder;
use Water\Module\TeapotModule\Tests\Fixture\Module\OtherModule\Controller\ControllerInvalid;
use Water\Module\TeapotModule\Tests\Fixture\Module\OtherModule\Controller\OtherTestController;
use Water\Module\TeapotModule\Tests\Fixture\Module\PombaCorpModule\Controller\TestController;

/**
 * Test Suite Class TemplateFinderTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateFinderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testFind()
    {
        $finder = new TemplateFinder($this->getContainerMock(array('modules' => $this->getModules())));
        $actual = $finder->find(array(new TestController(), 'index'));

        $this->assertEquals('PombaCorp::Test::index', $actual);
    }

    public function testFindInvalidArgumentException()
    {
        $finder = new TemplateFinder($this->getContainerMock(array('modules' => $this->getModules())));

        $this->setExpectedException('\InvalidArgumentException');
        $finder->find(array(new ControllerInvalid(), 'index'));
    }

    public function testFindNotRegisteredModuleExcpetion()
    {
        $finder = new TemplateFinder($this->getContainerMock(array('modules' => $this->getModules())));

        $this->setExpectedException('\InvalidArgumentException');
        $finder->find(array(new OtherTestController(), 'index'));
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

    private function getContainerMock(array $services)
    {
        $container = $this->getContainerMockBuilder()
                          ->getMock();
        foreach ($services as $id => $service) {
            $container->expects($this->any())
                      ->method('get')
                      ->with($this->equalTo($id))
                      ->will($this->returnValue($service));
        }
        return $container;
    }

    private function getModuleBagMock(array $modules)
    {
        $modules = $this->getModuleBagMockBuilder()
                        ->setConstructorArgs(array($modules))
                        ->setMethods(array('getIterator'))
                        ->getMock();
        $modules->expects($this->any())
                ->method('getIterator')
                ->will($this->returnValue(new \ArrayIterator($modules)));
        return $modules;
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

    private function getModules()
    {
        return $this->getModuleBagMock(array(
            'NotExist'  => $this->getModuleMock('Water\Module\TeapotModule\Tests\Fixture\Module\NotExistModule', 'NotExistModule'),
            'PombaCorp' => $this->getModuleMock('Water\Module\TeapotModule\Tests\Fixture\Module\PombaCorpModule', 'PombaCorpModule'),
        ));
    }
}