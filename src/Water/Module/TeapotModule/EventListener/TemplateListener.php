<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/10/13
 * Time: 19:26
 */
namespace Water\Module\TeapotModule\EventListener;

use \ReflectionClass;
use Water\Framework\Kernel\Bag\ModuleBag;
use Water\Framework\Kernel\Module\ModuleInterface;
use Water\Library\DependencyInjection\ContainerInterface;
use Water\Library\EventDispatcher\EventDispatcherInterface;
use Water\Library\EventDispatcher\SubscriberInterface;
use Water\Library\Http\Response;
use Water\Library\Kernel\Event\FilterControllerEvent;
use Water\Library\Kernel\Event\ResponseFromControllerResultEvent;
use Water\Library\Kernel\KernelEvents;

/**
 * Class TemplateListener
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateListener implements SubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container = null;

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
     * @param FilterControllerEvent    $event
     * @param string                   $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onKernelController(FilterControllerEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $resource = $event->getRequest()->getResource();

        if (
            $resource->has('_template')
            || !$resource->has('_controller')
            || !is_array($controller = $resource->get('_controller'))
        ) {
            return;
        }

        $class  = strtok($controller, '::');
        $method = strtok('::');

        $refController = new ReflectionClass($class);
        $modules       = $this->container->get('modules');
        $module        = $this->getModule($refController, $modules);

        $template = $module->getShortName() . '::'
                  . str_replace('Controller', '', $refController->getShortName()) . '::'
                  . $method;

        $resource->set('_template', $template);
    }

    /**
     * @param ReflectionClass $refController
     * @param ModuleBag       $modules
     * @return ModuleInterface
     *
     * @throws \InvalidArgumentException
     */
    private function getModule(ReflectionClass $refController, ModuleBag $modules)
    {
        $namespace = $refController->getNamespaceName();
        foreach ($modules as $module) {
            if (strpos($namespace, $module->getNamespaceName()) === 0) {
                return $module;
            }
        }

        /**
         * FIXME - create a TeapotException.
         */
        throw new \InvalidArgumentException(sprintf(
            'The controller "%s" not belongs to any registered module.',
            $refController->getName()
        ));
    }

    /**
     * @param ResponseFromControllerResultEvent $event
     * @param string                            $eventName
     * @param EventDispatcherInterface          $dispatcher
     */
    public function onKernelView(ResponseFromControllerResultEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $resource = $event->getRequest()->getResource();

        if (!$resource->has('_template')) {
            return;
        }

        $templateRender = $this->container->get('template_render');
        if (!is_object($templateRender) && !method_exists($templateRender, 'render')) {
            return;
        }

        $content = $templateRender->render($resource->get('_template'));
        $event->setResponse(Response::create($content));
    }

    // @codeCoverageIgnoreStart
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array('onKernelController', 64),
            KernelEvents::VIEW => array('onKernelView', 64),
        );
    }
    // @codeCoverageIgnoreEnd
}