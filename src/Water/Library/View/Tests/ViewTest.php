<?php
/**
 * User: Ivan C. Sanches
 * Date: 10/09/13
 * Time: 13:46
 */
namespace Water\Library\View\Tests;
use Water\Library\View\View;

/**
 * Class ViewTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ViewTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testRender()
    {
        $view = new View();
        $content = $view->render(__DIR__ . '/Resource/template.php');
        $this->assertNotEmpty($content);
    }
}
