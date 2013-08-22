<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/08/13
 * Time: 14:37
 */
namespace Water\Library\HttpProtocol\Tests;
use Water\Library\HttpProtocol\Request;

/**
 * Class RequestTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RequestTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGet()
    {
        $request = new Request(
            array('getIndex' => 'getValue'),
            array('postIndex' => 'postValue'),
            array('cookieIndex' => 'cookieValue'),
            array('fileIndex' => 'fileValue'),
            array(),
            ''
        );

        $this->assertEquals('getValue', $request->get('getIndex'));
        $this->assertEquals('postValue', $request->get('postIndex'));
        $this->assertEquals('cookieValue', $request->get('cookieIndex'));
        $this->assertEquals('fileValue', $request->get('fileIndex'));
    }
}
