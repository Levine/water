<?php
/**
 * User: Ivan C. Sanches
 * Date: 03/10/13
 * Time: 09:11
 */
namespace Water\Library\DependencyInjection\Compiler;
use Water\Library\DependencyInjection\Bag\ProcessBag;
use Water\Library\DependencyInjection\Compiler\Process\ExtensionProcess;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;

/**
 * Class ProcessConfiguration
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ProcessConfiguration
{
    /**
     * @var ProcessBag
     */
    private $processes = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->processes = new ProcessBag($this->getDefaultProcess());
    }

    /**
     * @return array
     */
    public function getDefaultProcess()
    {
        return array(
            new ExtensionProcess(),
        );
    }

    /**
     * @param array $processes
     * @return array
     */
    public function setProcesses(array $processes)
    {
        return $this->processes->fromArray($processes);
    }

    /**
     * @param ProcessInterface $process
     */
    public function addProcess(ProcessInterface $process)
    {
        $this->processes->append($process);
    }

    /**
     * @return ProcessBag
     */
    public function getProcesses()
    {
        return $this->processes;
    }
}