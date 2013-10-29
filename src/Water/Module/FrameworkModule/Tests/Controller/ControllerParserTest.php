<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/10/13
 * Time: 09:56
 */
namespace Water\Module\FrameworkModule\Tests\Controller;

use Water\Module\FrameworkModule\Controller\ControllerParser;

/**
 * Test Suite ControllerParserTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerParserTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerMock($moduleExist = true)
    {
        $methods = array(
            'hasParameter',
            'setParameters',
            'addParameter',
            'getParameters',
            'getParameter',
            'has',
            'setServices',
            'add',
            'getServices',
            'get'
        );
        $container = $this->getMock(
            '\Water\Library\DependencyInjection\ContainerInterface',
            $methods
        );
        $container->expects($this->any())
            ->method('get')
            ->with($this->equalTo('modules'))
            ->will($this->returnValue($this->getModuleBagMock($moduleExist)));

        return $container;
    }

    private function getModuleBagMock($moduleExist)
    {
        $bag = $this->getMockBuilder('\Water\Framework\Kernel\Bag\ModuleBag')
            ->disableOriginalConstructor()
            ->setMethods(array('has', 'get'))
            ->getMock();

        $bag->expects($this->any())
            ->method('has')
            ->with($this->equalTo('Some'))
            ->will($this->returnValue($moduleExist));

        $bag->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->getMockForAbstractClass('\Water\Framework\Kernel\Module\Module')));

        return $bag;
    }

    public function testParse()
    {
        $parser = new ControllerParser($this->getContainerMock(true));
        $controller = $parser->parse($expected = 'TestController::indexAction');

        $this->assertEquals($expected, $controller);
    }

    public function testParseShortName()
    {
        $parser = new ControllerParser($this->getContainerMock(true));
        $parser->parse('Some:Index:indexAction');
    }

    public function testModuleNotExist()
    {
        $parser = new ControllerParser($this->getContainerMock(false));

        $this->setExpectedException('Water\Library\Kernel\Exception\InvalidArgumentException');
        $parser->parse('Some:Index:indexAction');
    }

    public function testInvalidArgumentException()
    {
        $parser = new ControllerParser($this->getContainerMock(true));

        $this->setExpectedException('Water\Library\Kernel\Exception\InvalidArgumentException');
        $parser->parse('TestController::indexAction::invalidArgument');
    }
}
 