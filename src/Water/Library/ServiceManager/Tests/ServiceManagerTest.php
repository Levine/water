<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 15:39
 */
namespace Water\Library\ServiceManager\Tests;

use Water\Library\ServiceManager\ServiceManager;
use Water\Library\ServiceManager\Tests\Resource\Service;
use Water\Library\ServiceManager\Tests\Resource\ServiceManagerConfig;

/**
 * Class ServiceManagerTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceManagerTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var ServiceManagerConfig
     */
    private $config = null;

    protected function setUp()
    {
        $this->config = new ServiceManagerConfig();
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testSet()
    {
        $sm = new ServiceManager();
        $sm->set('service', array());

        $sm->enableOverride();
        $sm->set('service', array());

        $this->setExpectedException('\Water\Library\ServiceManager\Exception\ServiceOverrideDisabledException');

        $sm->disableOverride();
        $sm->set('service', array());
    }

    public function testHas()
    {
        $sm = new ServiceManager($this->config);
        $sm->set('service', new Service());

        $this->assertTrue($sm->has('service'));
        $this->assertTrue($sm->has('serviceFactory'));
        $this->assertTrue($sm->has('serviceInstantiable'));
        $this->assertFalse($sm->has('notExistService'));

        $sm->addAlias('service', 's');
        $this->assertTrue($sm->has('s'));

        $sm->addAlias('service', 'ser');
        $this->assertTrue($sm->has('s'));
        $this->assertTrue($sm->has('ser'));
    }

    public function testGet()
    {
        $sm = new ServiceManager($this->config);
        $sm->set('service', new Service());

        $this->assertInstanceOf(
            '\Water\Library\ServiceManager\Tests\Resource\Service',
            $sm->get('service')
        );
        $this->assertInstanceOf(
            '\Water\Library\ServiceManager\Tests\Resource\Service',
            $sm->get('serviceFactory')
        );
        $this->assertInstanceOf(
            '\Water\Library\ServiceManager\Tests\Resource\Service',
            $sm->get('serviceInstantiable')
        );

        $this->setExpectedException('\Water\Library\ServiceManager\Exception\ServiceNotFoundException');
        $sm->get('notExistService');
    }
}
