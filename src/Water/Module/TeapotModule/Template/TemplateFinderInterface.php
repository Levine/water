<?php
/**
 * User: Ivan C. Sanches
 * Date: 07/11/13
 * Time: 10:26
 */
namespace Water\Module\TeapotModule\Template;

/**
 * Interface TemplateFinderInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface TemplateFinderInterface
{
    /**
     * Find a template from specified controller.
     *
     * @param array $controller
     * @return string
     */
    public function find(array $controller);
}