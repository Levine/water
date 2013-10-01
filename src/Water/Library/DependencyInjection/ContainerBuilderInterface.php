<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:36
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Compiler\CompilerInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;

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
     * @param CompilerInterface $compileProcessor
     * @return ContainerBuilderInterface
     */
    public function setCompiler(CompilerInterface $compileProcessor);

    /**
     * @return CompilerInterface
     */
    public function getCompiler();

    /**
     * @param ProcessInterface $process
     * @return ContainerBuilderInterface
     */
    public function addProcess(ProcessInterface $process);

    /**
     * Compile the current container builder.
     */
    public function compile();
}