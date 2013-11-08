<?php
/**
 * User: Ivan C. Sanches
 * Date: 25/09/13
 * Time: 15:53
 */
namespace Water\Library\Http\Tests;
use Water\Library\Http\RedirectResponse;

/**
 * Class RedirectResponseTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RedirectResponseTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testCreate()
    {
        $response = RedirectResponse::create('/home');

        $this->assertEquals('/home', $response->getHeaders()->get('Location'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testSetTargetUrl()
    {
        $response = new RedirectResponse('/home');

        $this->assertEquals('/home', $response->getHeaders()->get('Location'));
        $this->assertNotEmpty($response->getContent());
    }

    public function testSetTargetUrlException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new RedirectResponse('');
    }
}
