<?php
/**
 * User: Ivan C. Sanches
 * Date: 23/09/13
 * Time: 08:20
 */
namespace Water\Library\Kernel\Tests\Resolver;

use Water\Library\Http\Request;
use Water\Library\Kernel\Resolver\ControllerResolver;
use Water\Library\Kernel\Tests\Resolver\Resource\Controller;
use Water\Library\Kernel\Tests\Resolver\Resource\InvokableClass;

/**
 * Class ControllerResolverTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolverTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getRequest($controller)
    {
        return Request::create(
            '/',
            'GET',
            array(),
            array('_controller' => $controller)
        );
    }

    public function testGetController()
    {
        $resolver = new ControllerResolver();

        $actual = $resolver->getController($this->getRequest($expected = function () { return true; }));
        $this->assertEquals($expected, $actual);

        $actual = $resolver->getController($this->getRequest($expected = new InvokableClass()));
        $this->assertEquals($actual, $expected);

        $actual = $resolver->getController($this->getRequest('\Water\Library\Kernel\Tests\Resolver\Resource\InvokableClass'));
        $this->assertEquals(new InvokableClass(), $actual);

        $actual = $resolver->getController($this->getRequest($expected = 'is_string'));
        $this->assertEquals($expected, $actual);

        $actual = $resolver->getController($this->getRequest($expected = array(new Controller(), 'indexAction')));
        $this->assertEquals($expected, $actual);

        $actual = $resolver->getController($this->getRequest('\Water\Library\Kernel\Tests\Resolver\Resource\Controller::indexAction'));
        $this->assertEquals(array(new Controller(), 'indexAction'), $actual);
    }

    public function testGetControllerInvalidRequest()
    {
        $resolver = new ControllerResolver();

        $controller = $resolver->getController(Request::create('/'));
        $this->assertFalse($controller);
    }

    public function testGetControllerInvalidFormat()
    {
        $resolver = new ControllerResolver();

        $this->setExpectedException('\Water\Library\Kernel\Exception\InvalidArgumentException');
        $resolver->getController($this->getRequest('\Water\Library\Kernel\Tests\Resolver\Resource\Controller:indexAction'));
    }

    public function testGetControllerClassNotExist()
    {
        $resolver = new ControllerResolver();

        $this->setExpectedException('\Water\Library\Kernel\Exception\InvalidArgumentException');
        $resolver->getController($this->getRequest('\Water\Library\Kernel\Tests\Resolver\Resource\ClassNotExist::indexAction'));
    }

    public function testGetArguments()
    {
        $resolver = new ControllerResolver();

        $args = $resolver->getArguments(Request::create('/'));
        $this->assertInternalType('array', $args);
    }
}
