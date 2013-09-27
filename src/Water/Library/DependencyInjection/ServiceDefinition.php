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

    // @codeCoverageIgnoreStart
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