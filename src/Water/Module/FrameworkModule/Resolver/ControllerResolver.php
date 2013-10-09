<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 14:44
 */
namespace Water\Module\FrameworkModule\Resolver;

use Water\Library\DependencyInjection\ContainerAwareInterface;
use Water\Library\DependencyInjection\ContainerInterface;
use Water\Library\Http\Request;
use Water\Library\Kernel\Exception\InvalidArgumentException;
use Water\Library\Kernel\Resolver\ControllerResolver as BaseControllerResolver;

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
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function createController($controller)
    {
        if (preg_match(
            '/^(?P<module>[a-zA-Z0-9_.-]+)\:(?P<controller>[a-zA-Z0-9_.-]+)\:(?P<method>[a-zA-Z0-9_.-]+)$/',
            $controller,
            $matches
        )) {
            $modules = $this->container->get('modules');
            if ($modules->has($matches['module'])) {
                $controller = $modules->get($matches['module'])->getNamespaceName()
                            . '\\Controller\\' . $matches['controller'] . '::' . $matches['method'];
            } else {
                throw new InvalidArgumentException(sprintf(
                    'No exist module with name "%s". ("%s" given)',
                    $matches['module'],
                    $controller
                ));
            }
        }

        if (substr_count($controller, '::') != 1) {
            throw new InvalidArgumentException(sprintf(
                'Controller has to be a "array", "invokable class", "function", '
                . '"<ControllerFullName>::<methodName>" or "<ModuleName>:<ControllerShortName>:<methodName>" '
                . '("%s" given).',
                $controller
            ));
        }

        $class  = strtok($controller, '::');
        $method = strtok('::');

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