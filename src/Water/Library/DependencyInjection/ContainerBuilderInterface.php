<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:36
 */
namespace Water\Library\DependencyInjection;

use Water\Library\DependencyInjection\Bag\DefinitionBag;
use Water\Library\DependencyInjection\Bag\ExtensionBag;
use Water\Library\DependencyInjection\Compiler\CompilerInterface;
use Water\Library\DependencyInjection\Compiler\Process\ProcessInterface;
use Water\Library\DependencyInjection\Exception\InvalidArgumentException;
use Water\Library\DependencyInjection\Exception\NotExistParameterException;
use Water\Library\DependencyInjection\Exception\NotExistServiceException;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

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
     * Return all definitions with the specified tag.
     *
     * @param string $tag
     * @return DefinitionBag
     */
    public function getDefinitionsByTag($tag);

    /**
     * @param string $id
     * @return Definition|null
     */
    public function getDefinition($id);

    /**
     * @param string             $id
     * @param ExtensionInterface $extension
     * @return ExtensionInterface
     */
    public function registerExtension($id, ExtensionInterface $extension);

    /**
     * @param string $id
     * @return bool
     */
    public function hasExtension($id);

    /**
     * @param array $extensions
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public function setExtensions(array $extensions);

    /**
     * @param string $id
     * @return ContainerBuilderInterface
     */
    public function removeExtension($id);

    /**
     * @param string             $id
     * @param ExtensionInterface $extension
     * @return ContainerBuilderInterface
     */
    public function addExtension($id, ExtensionInterface $extension);

    /**
     * @return ExtensionBag
     */
    public function getExtensions();

    /**
     * @param string $id
     * @return ExtensionInterface|null
     */
    public function getExtension($id);

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
     *
     * @throws NotExistParameterException
     * @throws NotExistServiceException
     * @throws InvalidArgumentException
     * @throws \ReflectionException
     */
    public function compile();
}