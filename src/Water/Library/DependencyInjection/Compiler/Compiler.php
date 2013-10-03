<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:16
 */
namespace Water\Library\DependencyInjection\Compiler;

use Water\Library\DependencyInjection\Bag\ProcessBag;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;

/**
 * Class Compiler
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Compiler implements CompilerInterface
{
    /**
     * @var ProcessConfiguration
     */
    protected $processConfiguration = array();

    /**
     * Constructor.
     */
    public function __construct(ProcessConfiguration $config = null)
    {
        $this->processConfiguration = ($config === null) ? new ProcessConfiguration() : $config;
    }

    /**
     * Compile the ContainerBuilder.
     *
     * @param ContainerBuilderInterface $container
     */
    public function compile(ContainerBuilderInterface $container)
    {
        foreach ($this->getProcesses() as $process) {
            $process->process($container);
        }
    }

    /**
     * @param array $processes
     * @return array
     */
    public function setProcesses(array $processes)
    {
        return $this->processConfiguration->setProcesses($processes);
    }

    /**
     * @param ProcessInterface $process
     * @return CompilerInterface
     */
    public function addProcess(ProcessInterface $process)
    {
        $this->processConfiguration->addProcess($process);
        return $this;
    }

    /**
     * @return ProcessBag
     */
    public function getProcesses()
    {
        return $this->processConfiguration->getProcesses();
    }
}