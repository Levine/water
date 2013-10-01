<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 22:59
 */
namespace Water\Library\DependencyInjection\Tests\Compiler;

use Water\Library\DependencyInjection\Compiler\Compiler;

/**
 * Class CompilerTest
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */

class CompilerTest extends \PHPUnit_Framework_TestCase 
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    private function getContainerBuilderMock()
    {
        $container = $this->getMock('\Water\Library\DependencyInjection\ContainerBuilderInterface');

        return $container;
    }

    private function getProcessMock()
    {
        $process = $this->getMock(
            '\Water\Library\DependencyInjection\Compiler\Process\ProcessInterface',
            array('process')
        );

        $process->expects($this->any())
                ->method('process')
                ->with($this->isInstanceOf('\Water\Library\DependencyInjection\ContainerBuilderInterface'));

        return $process;
    }

    public function testConstructor()
    {
        $compiler = new Compiler();

        $this->assertInstanceOf('\Water\Library\DependencyInjection\Compiler\Compiler', $compiler);
    }

    public function testProcess()
    {
        $compiler = new Compiler();

        $compiler->addProcess($this->getProcessMock());
        $compiler->addProcess($this->getProcessMock());

        $this->assertCount(2, $compiler->getProcesses());

        $old = $compiler->setProcesses(array(
            $this->getProcessMock(),
            $this->getProcessMock(),
            $this->getProcessMock(),
            $this->getProcessMock(),
        ));

        $this->assertCount(2, $old);
        $this->assertCount(4, $compiler->getProcesses());
    }

    public function testCompile()
    {
        $compiler = new Compiler();

        $compiler->setProcesses(array(
            $this->getProcessMock(),
            'notProcessInterface',
        ));

        $compiler->compile($this->getContainerBuilderMock());
    }
}
