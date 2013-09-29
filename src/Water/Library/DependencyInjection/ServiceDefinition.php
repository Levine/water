<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 16:06
 */
namespace Water\Library\DependencyInjection;

/**
 * Class ServiceDefinition
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceDefinition
{
    /**
     * @var string
     */
    private $class = '';

    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @var array
     */
    private $methodsCall = array();
    private $tags = array();

    /**
     * Constructor.
     *
     * @param string $class
     * @param array  $args
     * @param array  $tags
     */
    public function __construct($class, array $args = array(), array $tags = array())
    {
        $this->class     = $class;
        $this->arguments = $args;
        $this->tags      = $tags;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param $methodName
     * @param array $args
     * @return ServiceDefinition
     */
    public function addMethodCall($methodName, array $args = array())
    {
        unset($this->methodsCall[$methodName]);
        $this->methodsCall[$methodName] = $args;
        return $this;
    }

    /**
     * @param array $methodsCall
     * @return ServiceDefinition
     */
    public function setMethodsCall($methodsCall)
    {
        $this->methodsCall = $methodsCall;
        return $this;
    }

    /**
     * @return array
     */
    public function getMethodsCall()
    {
        return $this->methodsCall;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTag($name)
    {
        return (array_search($name, $this->tags) !== false) ? true : false;
    }

    /**
     * @param $tag
     * @return ServiceDefinition
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @param array $tags
     * @return ServiceDefinition
     */
    public function setTags($tags)
    {
        $this->tags = (array) $tags;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }


    /**
     * Define argument to the service constructor.
     *
     * @param mixed $arg
     * @return ServiceDefinition
     */
    public function addArgument($arg = null)
    {
        $this->arguments[] = $arg;
        return $this;
    }

    /**
     * Define arguments to the service constructor.
     *
     * @param array $args
     * @return ServiceDefinition
     */
    public function setArguments(array $args = array())
    {
        $this->arguments = $args;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    // @codeCoverageIgnoreEnd
}