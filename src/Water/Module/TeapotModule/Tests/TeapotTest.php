<?php
/**
 * User: Ivan C. Sanches 
 * Date: 04/11/13
 * Time: 16:18
 */
namespace Water\Module\TeapotModule\Tests;

use Water\Module\TeapotModule\Teapot;

/**
 * Class TeapotTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TeapotTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getTemplateParserMock()
    {
        return $this->getMockBuilder('\Water\Module\TeapotModule\Template\TemplateParser');
    }

    public function testExtend()
    {
        $parser = $this->getTemplateParserMock()
                       ->disableOriginalConstructor()
                       ->setMethods(array('parse'))
                       ->getMock();
        $parser->expects($this->any())
               ->method('parse')
               ->with($this->equalTo('TestModule::Index::index'))
               ->will($this->returnValue(__DIR__ . '/Resource/view/test.php'));

        $teapot = new Teapot(null, $parser);
        $teapot->extend('TestModule::Index::index');
        $this->assertAttributeContains(__DIR__ . '/Resource/view/test.php', 'extendStack', $teapot);
    }
}
 