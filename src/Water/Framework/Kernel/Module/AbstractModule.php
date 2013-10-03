<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 14:40
 */
namespace Water\Framework\Kernel\Module;

use Water\Library\DependencyInjection\ContainerAware;

/**
 * Class AbstractModule
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
abstract class AbstractModule extends ContainerAware implements ModuleInterface
{
    /**
     * @var \ReflectionClass
     */
    private $reflection = null;

    /**
     * {@inheritdoc}
     */
    public function getReflection()
    {
        if ($this->reflection === null) {
            $this->reflection = new \ReflectionClass($this);
        }
        return $this->reflection;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getReflection()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespaceName()
    {
        return $this->getReflection()->getNamespaceName();
    }

    /**
     * {@inheritdoc}
     */
    public function getShortName()
    {
        return $this->getReflection()->getShortName();
    }

    /**
     * {@inheritdoc}
     */
    public function getFileName()
    {
        return $this->getReflection()->getFileName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return dirname($this->getFileName());
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        $class = str_replace('Module', 'Extension', $this->getShortName());
        $class = $this->getNamespaceName() . '\\Extension\\' . $class;

        if (class_exists($class)
            && is_a($extension = new $class(), 'Water\Library\DependencyInjection\Extension\ExtensionInterface')
        ) {
            return $extension;
        }
        return null;
    }
}