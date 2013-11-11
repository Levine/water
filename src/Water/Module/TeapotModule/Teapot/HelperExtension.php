<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/11/13
 * Time: 13:40
 */
namespace Water\Module\TeapotModule\Teapot;

use Water\Library\DependencyInjection\ContainerAware;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class HelperExtension
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class HelperExtension extends ContainerAware implements ExtensionInterface
{
    /**
     * Extend the current container builder(helper).
     *
     * @param ContainerBuilderInterface $helper
     */
    public function extend(ContainerBuilderInterface $helper)
    {
        $request = $this->container->get('request');
        $router  = $this->container->get('router');

        $helper->register('css', '\Water\Module\TeapotModule\Teapot\Helper\Css');

        $helper->register('generate', '\Water\Module\TeapotModule\Teapot\Helper\GenerateUrl')
               ->setArguments(array($router));

        $helper->register('path', '\Water\Module\TeapotModule\Teapot\Helper\Path')
               ->addMethodCall('setSchemeHost', array($request->getSchemeHost()));

        $helper->register('script', '\Water\Module\TeapotModule\Teapot\Helper\Script');
    }
}