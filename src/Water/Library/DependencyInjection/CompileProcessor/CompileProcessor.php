<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:16
 */
namespace Water\Library\DependencyInjection\CompileProcessor;

use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\CompileProcessor\Process\ProcessInterface;
use Water\Library\DependencyInjection\Bag\ProcessBag;

/**
 * Class CompileProcessor
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class CompileProcessor implements CompileProcessorInterface
{
    /**
     * @var ProcessBag
     */
    protected $processes = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->processes = new ProcessBag();
    }

    /**
     * Compile the ContainerBuilder.
     *
     * @param ContainerBuilderInterface $container
     */
    public function compile(ContainerBuilderInterface $container)
    {
        foreach ($this->processes as $process) {
            if (is_a($process, 'Water\Library\DependencyInjection\CompileProcessor\Process\ProcessInterface')) {
                $process->process($container);
            }
        }
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
     * @return CompileProcessorInterface
     */
    public function addProcess(ProcessInterface $process)
    {
        $this->processes[] = $process;
        return $this;
    }

    /**
     * @return ProcessBag
     */
    public function getProcesses()
    {
        return $this->processes;
    }
}