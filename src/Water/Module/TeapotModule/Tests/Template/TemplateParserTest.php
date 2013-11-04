<?php
/**
 * User: Ivan C. Sanches 
 * Date: 04/11/13
 * Time: 15:47
 */
namespace Water\Module\TeapotModule\Tests\Template;

use Water\Module\TeapotModule\Template\TemplateParser;

/**
 * Test Suite TemplateParserTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateParserTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerBuilderMock()
    {
        return $this->getMockBuilder('\Water\Library\DependencyInjection\ContainerBuilder');
    }

    private function getModuleBagMock()
    {
        return $this->getMockBuilder('\Water\Framework\Kernel\Bag\ModuleBag');
    }

    private function getModuleMock()
    {
        return $this->getMockBuilder('\Water\Framework\Kernel\Module\Module');
    }

    public function testParse()
    {
        $module = $this->getModuleMock()
                       ->setMethods(array('getResourcePath'))
                       ->getMock();
        $module->expects($this->any())
               ->method('getResourcePath')
               ->will($this->returnValue(__DIR__ . '/TestModule/Resource'));

        $modules = $this->getModuleBagMock()
                        ->setMethods(array('has', 'get'))
                        ->getMock();
        $modules->expects($this->any())
                ->method('has')
                ->with($this->equalTo('TestModule'))
                ->will($this->returnValue(true));
        $modules->expects($this->any())
                ->method('get')
                ->with($this->equalTo('TestModule'))
                ->will($this->returnValue($module));

        $container = $this->getContainerBuilderMock()
                          ->setMethods(array('get'))
                          ->getMock();
        $container->expects($this->any())
                  ->method('get')
                  ->with($this->equalTo('modules'))
                  ->will($this->returnValue($modules));

        $teapot = new TemplateParser($container);

        $actual = $teapot->parse('TestModule::Index::index');
        $this->assertEquals(__DIR__ . '/TestModule/Resource/view/template/controller/Index/index.php', $actual);

        $actual = $teapot->parse('TestModule::layout');
        $this->assertEquals(__DIR__ . '/TestModule/Resource/view/template/layout.php', $actual);

        $actual = $teapot->parse('./template.php');
        $this->assertEquals('./template.php', $actual);
    }
}
 