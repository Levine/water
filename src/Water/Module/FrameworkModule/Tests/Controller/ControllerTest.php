<?php
/**
 * User: Ivan C. Sanches
 * Date: 04/10/13
 * Time: 14:51
 */
namespace Water\Module\FrameworkModule\Tests\Controller;

/**
 * Class ControllerTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function getContainerMock($serviceId, $return = null)
    {
        $container = $this->getMockBuilder('\Water\Library\DependencyInjection\Container')
                          ->disableOriginalConstructor()
                          ->setMethods(array('get'))
                          ->getMock();

        $container->expects($this->any())
                  ->method('get')
                  ->with($serviceId)
                  ->will($this->returnValue($return));

        return $container;
    }

    public function testGetRequest()
    {
        $controller = $this->getMockForAbstractClass('\Water\Module\FrameworkModule\Controller\Controller');

        $request = $this->getMockBuilder('\Water\Library\Http\Request')
                        ->disableOriginalConstructor()
                        ->getMock();
        $controller->setContainer($this->getContainerMock('request', $request));

        $this->assertInstanceOf('\Water\Library\Http\Request', $controller->getRequest());
    }

    public function testGenerateUrl()
    {
        $controller = $this->getMockForAbstractClass('\Water\Module\FrameworkModule\Controller\Controller');

        $router = $this->getMockBuilder('\Water\Library\Router\Router')
                       ->disableOriginalConstructor()
                       ->setMethods(array('generate'))
                       ->getMock();
        $router->expects($this->any())
               ->method('generate')
               ->will($this->returnValue('/'));
        $controller->setContainer($this->getContainerMock('router', $router));

        $this->assertEquals('/', $controller->generateUrl('home'));
    }

    public function testRedirect()
    {
        $controller = $this->getMockForAbstractClass('\Water\Module\FrameworkModule\Controller\Controller');
        $this->assertInstanceOf('\Water\Library\Http\RedirectResponse', $controller->redirect('/'));
    }
}
