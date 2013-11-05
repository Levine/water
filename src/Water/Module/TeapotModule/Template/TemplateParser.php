<?php
/**
 * User: Ivan C. Sanches 
 * Date: 04/11/13
 * Time: 14:11
 */
namespace Water\Module\TeapotModule\Template;

use Water\Library\DependencyInjection\ContainerInterface;

/**
 * Class TemplateParser
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateParser implements TemplateParserInterface
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
     * {@inheritdoc}
     */
    public function parse($template)
    {
        $pattern = '/^(?P<module>[a-zA-Z0-9_.-]+)\:\:(?P<template>[a-zA-Z0-9_.-]+)$/';
        if (preg_match($pattern, $template, $matches)) {
            $modules = $this->container->get('modules');
            if ($modules->has($matches['module'])) {
                $template = $modules->get($matches['module'])->getResourcePath()
                          . '/view/template/'
                          . $matches['template'] . '.php';
            }

            goto end;
        }

        $pattern = '/^(?P<module>[a-zA-Z0-9_.-]+)\:\:(?P<controller>[a-zA-Z0-9_.-]+)\:\:(?P<template>[a-zA-Z0-9_.-]+)$/';
        if (preg_match($pattern, $template, $matches)) {
            $modules = $this->container->get('modules');
            if ($modules->has($matches['module'])) {
                $template = $modules->get($matches['module'])->getResourcePath()
                          . '/view/template/controller/'
                          . $matches['controller']
                          . '/' . $matches['template'] . '.php';
            }

            goto end;
        }

        end:
        return $template;
    }
}