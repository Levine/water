<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:16
 */
namespace Water\Library\DependencyInjection\CompileProcessor;

use Water\Library\DependencyInjection\Bag\ProcessBag;
use Water\Library\DependencyInjection\CompileProcessor\Process\ProcessInterface;
use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Interface CompileProcessorInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface CompileProcessorInterface
{
    /**
     * Compile the ContainerBuilder.
     *
     * @param ContainerBuilderInterface $container
     */
    public function compile(ContainerBuilderInterface $container);

    /**
     * @param array $processes
     * @return array
     */
    public function setProcesses(array $processes);

    /**
     * @param ProcessInterface $process
     * @return CompileProcessorInterface
     */
    public function addProcess(ProcessInterface $process);

    /**
     * @return ProcessBag
     */
    public function getProcesses();
}