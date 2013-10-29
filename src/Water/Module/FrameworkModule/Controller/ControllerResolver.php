<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 14:44
 */
namespace Water\Module\FrameworkModule\Controller;

use Water\Library\DependencyInjection\ContainerAwareInterface;
use Water\Library\DependencyInjection\ContainerInterface;
use Water\Library\Kernel\Exception\InvalidArgumentException;
use Water\Library\Kernel\Controller\ControllerResolver as BaseControllerResolver;

/**
 * Class ControllerResolver
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerResolver extends BaseControllerResolver
{
    /**
     * @var ContainerInterface
     */
    protected $container = null;

    /**
     * @var ControllerParserInterface
     */
    protected $parser = null;

    /**
     * Constructor.
     *
     * @param ContainerInterface        $container
     * @param ControllerParserInterface $parser
     */
    public function __construct(ContainerInterface $container, ControllerParserInterface $parser = null)
    {
        $this->container = $container;
        $this->parser    = ($parser !== null) ? $parser : new ControllerParser($this->container);
    }

    /**
     * {@inheritdoc}
     */
    protected function createController($controller)
    {
        $controller = $this->parser->parse($controller);
        $class      = strtok($controller, '::');
        $method     = strtok('::');

        if (!class_exists($class, true)
            || !is_callable($return = array($controller = new $class(), $method))
        ) {
            throw new InvalidArgumentException("Controller isn't a valid class or isn't callable.");
        }

        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        return $return;
    }
}