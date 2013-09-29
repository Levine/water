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

    /**
     * {@inheritdoc}
     */
    public function getController(Request $request)
    {
        $controller = parent::getController($request);

        if (is_a($controller, 'Water\Library\DependencyInjection\ContainerAwareInterface')) {
            $controller->setContainer($this->container);
        }

        return $controller;
    }
}