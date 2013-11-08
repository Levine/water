<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/10/13
 * Time: 19:26
 */
namespace Water\Module\TeapotModule\EventListener;

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
        $resource   = $event->getRequest()->getResource();
        $controller = $event->getController();

        if (
            $resource->has('_template')
            || !is_array($controller)
            || !$this->container->has('template.finder')
        ) {
            return;
        }

        $template = $this->container->get('template.finder')->find($controller);
        $resource->set('_template', $template);
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

        $templateRender = $this->container->get('template');
        if (!is_object($templateRender) && !method_exists($templateRender, 'render')) {
            return;
        }

        $content = $templateRender->render($resource->get('_template'), $event->getControllerResult());
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