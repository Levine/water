<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 15:37
 */
namespace Water\Library\DependencyInjection;

/**
 * Class Definition
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Definition
{
    /**
     * @var string
     */
    private $class = '';

    /**
     * @var string
     */
    private $arguments = '';

    /**
     * @var array
     */
    private $methodsCall = array();

    /**
     * @var array
     */
    private $tags = array();

    /**
     * Constructor.
     *
     * @param string $class
     * @param array  $args
     */
    public function __construct($class, array $args = array())
    {
        $this->class     = $class;
        $this->arguments = $args;
    }

    /**
     * @return bool
     */
    public function hasMethodsCall()
    {
        return (count($this->methodsCall) > 0);
    }

    /**
     * Return the key for tag name if it's found, FALSE otherwise.
     *
     * @param $tag
     * @return mixed
     */
    public function hasTag($tag)
    {
        return (array_search($tag, $this->tags) !== false) ? true : false;
    }

    // @codeCoverageIgnoreStart
    /**
     * @param array $arguments
     * @return Definition
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return string
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string $class
     * @return Definition
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param array $methodsCall
     * @return Definition
     */
    public function setMethodsCall(array $methodsCall)
    {
        $this->methodsCall = $methodsCall;
        return $this;
    }

    /**
     * @param string $methodName
     * @param array  $args
     * @return Definition
     */
    public function addMethodCall($methodName, array $args = array())
    {
        $this->methodsCall[] = array($methodName, $args);
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
     * @param array $tags
     * @return Definition
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param string $tag
     * @return Definition
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
    // @codeCoverageIgnoreStart
}