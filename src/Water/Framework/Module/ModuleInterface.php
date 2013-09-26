<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 14:40
 */
namespace Water\Framework\Kernel\Module;

/**
 * Interface ModuleInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ModuleInterface
{
    /**
     * @return \Reflection
     */
    public function getReflection();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getNamespaceName();

    /**
     * @return string
     */
    public function getShortName();

    /**
     * @return string
     */
    public function getFileName();

    /**
     * @return string
     */
    public function getPath();
}