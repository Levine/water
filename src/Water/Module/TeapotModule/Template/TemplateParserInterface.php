<?php
/**
 * User: Ivan C. Sanches 
 * Date: 04/11/13
 * Time: 14:10
 */
namespace Water\Module\TeapotModule\Template;

/**
 * Interface TemplateParserInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface TemplateParserInterface
{
    /**
     * Parse a template name.
     *
     * @param string $template
     * @return string
     */
    public function parse($template);
} 