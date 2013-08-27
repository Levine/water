<?php
/**
 * User: Ivan C. Sanches
 * Date: 23/08/13
 * Time: 21:41
 */
namespace Water\Library\Http\Tests\Bag;
use Water\Library\Http\Bag\HeaderBag;

/**
 * TestCase HeaderBagTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HeaderBagTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testConstruct()
    {
        $headerBag = new HeaderBag(array(
            'HOST'              => 'localhost',
            'USER_AGENT'        => 'Water/1.0',
            'ACCEPT'            => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'ACCEPT_LANGUAGE'   => 'pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
            'ACCEPT_CHARSET'    => 'utf-8,ISO-8859-1;q=0.7,*;q=0.7',
            'CONTENT_LENGTH'    => 348,
        ));

        $this->assertEquals('localhost', $headerBag->get('host'));
        $this->assertEquals(348, $headerBag->get('content-length'));
    }

    public function testSet()
    {
        $headerBag = new HeaderBag();

        $headerBag->offsetSet('ACCEPT_LANGUAGE', 'pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4');
        $headerBag->offsetSet('AccepT-CharseT', 'utf-8,ISO-8859-1;q=0.7,*;q=0.7');

        $this->assertEquals('pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4', $headerBag->get('accept-language'));
        $this->assertEquals('utf-8,ISO-8859-1;q=0.7,*;q=0.7', $headerBag->get('accept-charset'));
    }

    public function testToString()
    {
        $headerBag = new HeaderBag(array(
            'HOST'              => 'localhost',
            'USER_AGENT'        => 'Water/1.0',
        ));
        $string = "Host: localhost\r\n";
        $string .= "User-Agent: Water/1.0\r\n";

        $this->assertEquals($string, (string) $headerBag);
    }
}
