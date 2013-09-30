<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:36
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\CompileProcessor\CompileProcessorInterface;
use Water\Library\DependencyInjection\CompileProcessor\Process\ProcessInterface;

/**
 * Interface ContainerBuilderInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ContainerBuilderInterface extends ContainerInterface
{
    /**
     * @param string $id
     * @param string $class
     * @param array  $args
     * @return Definition
     */
    public function register($id, $class, array $args = array());

    /**
     * @param string $id
     * @return bool
     */
    public function hasDefinition($id);

    /**
     * @param array $definitions
     * @return array
     */
    public function setDefinitions(array $definitions);

    /**
     * @param string     $id
     * @param Definition $definition
     * @return ContainerBuilderInterface
     */
    public function addDefinition($id, Definition $definition);

    /**
     * @return DefinitionBag
     */
    public function getDefinitions();

    /**
     * @param string $id
     * @return Definition|null
     */
    public function getDefinition($id);

    /**
     * @param CompileProcessorInterface $compileProcessor
     * @return ContainerBuilderInterface
     */
    public function setCompileProcessor(CompileProcessorInterface $compileProcessor);

    /**
     * @return CompileProcessorInterface
     */
    public function getCompileProcessor();

    /**
     * @param ProcessInterface $process
     * @return ContainerBuilderInterface
     */
    public function addCompileProcess(ProcessInterface $process);

    /**
     * Compile the current container builder.
     */
    public function compile();
}