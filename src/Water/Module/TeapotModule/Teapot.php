<?php
/**
 * User: Ivan C. Sanches 
 * Date: 04/11/13
 * Time: 14:08
 */
namespace Water\Module\TeapotModule;

use Teapot\Teapot as BasicTeapot;
use Water\Library\DependencyInjection\ContainerBuilderInterface;
use Water\Module\TeapotModule\Template\TemplateParserInterface;

/**
 * Class Teapot
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Teapot extends BasicTeapot
{
    /**
     * @var TemplateParserInterface
     */
    private $parser = null;

    /**
     * {@inheritdoc}
     *
     * @param TemplateParserInterface   $parser
     */
    public function __construct(ContainerBuilderInterface $helpers = null, TemplateParserInterface $parser = null)
    {
        parent::__construct($helpers);
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function extend($template)
    {
        if ($this->parser !== null) {
            $template = $this->parser->parse($template);
        }
        parent::extend($template);
    }
} 