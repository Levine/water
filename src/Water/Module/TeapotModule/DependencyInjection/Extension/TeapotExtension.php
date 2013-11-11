<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/10/13
 * Time: 19:20
 */
namespace Water\Module\TeapotModule\DependencyInjection\Extension;

use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Library\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class TeapotExtension
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TeapotExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function extend(ContainerBuilderInterface $container)
    {
        $container->addParameter('template.render.class', '\Water\Module\TeapotModule\Teapot');
        $container->addParameter('template.helpers.class', '\Water\Library\DependencyInjection\ContainerBuilder');
        $container->addParameter('template.listener.class', '\Water\Module\TeapotModule\EventListener\TemplateListener');
        $container->addParameter('template.finder.class', '\Water\Module\TeapotModule\Template\TemplateFinder');
        $container->addParameter('template.parser.class', '\Water\Module\TeapotModule\Template\TemplateParser');

        $container->register('template.listener', '%template.listener.class%')
                  ->setArguments(array('#service_container'))
                  ->addTag('kernel.dispatcher_subscriber');

        $container->register('template.finder', '%template.finder.class%')
                  ->setArguments(array('#service_container'));

        $container->register('template.parser', '%template.parser.class%')
                  ->setArguments(array('#service_container'));

        $container->register('template.helpers', '%template.helpers.class%');
        $container->register('template.render', '%template.render.class%')
                  ->setArguments(array('#template.helpers', '#template.parser'));
    }
}