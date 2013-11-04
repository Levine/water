<?php
/**
 * User: Ivan C. Sanches 
 * Date: 29/10/13
 * Time: 09:44
 */
namespace Water\Module\FrameworkModule\Controller;

use Water\Library\DependencyInjection\ContainerInterface;
use Water\Library\Kernel\Exception\InvalidArgumentException;

/**
 * Class ControllerParser
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerParser implements ControllerParserInterface
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

    /**
     * {@inheritdoc}
     */
    public function parse($controller)
    {
        $pattern = '/^(?P<module>[a-zA-Z0-9_.-]+)\:(?P<controller>[a-zA-Z0-9_.-]+)\:(?P<method>[a-zA-Z0-9_.-]+)$/';
        if (preg_match($pattern, $controller, $matches)) {
            $modules = $this->container->get('modules');
            if ($modules->has($matches['module'])) {
                $controller = $modules->get($matches['module'])->getNamespaceName()
                            . '\\Controller\\' . $matches['controller'] . 'Controller::'
                            . $matches['method'];
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

        return $controller;
    }
}