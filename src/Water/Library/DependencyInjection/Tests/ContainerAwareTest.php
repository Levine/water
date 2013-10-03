<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 09:25
 */
namespace Water\Library\DependencyInjection\Tests;

use Water\Library\DependencyInjection\ContainerAware;

/**
 * Class ContainerAwareTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ContainerAwareTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerMock()
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

        return $container;
    }

    public function testContainerAware()
    {
        $container = new ContainerAwareImplementation();

        $container->setContainer($this->getContainerMock());
        $this->assertAttributeInstanceOf('\Water\Library\DependencyInjection\ContainerInterface', 'container', $container);
    }
}

class ContainerAwareImplementation extends ContainerAware
{
}
