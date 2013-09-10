<?php
/**
 * User: Ivan C. Sanches
 * Date: 10/09/13
 * Time: 13:45
 */
namespace Water\Library\View;

use \Closure;

/**
 * Class View
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class View
{
    /**
     * @var array
     */
    private $blocks = array();

    /**
     * @var string
     */
    private $blockNames = array();

    /**
     * @var array
     */
    private $extendStack = array();

    /**
     * Define the start of block.
     *
     * @param string $name
     * @param Closure $callback
     */
    public function startBlock($name, Closure $callback = null)
    {
        array_push($this->blockNames, $name);
        ob_start($callback);
    }

    /**
     * Define the end of block.
     */
    public function endBlock()
    {
        $this->blocks[array_pop($this->blockNames)] = ob_get_clean();
    }

    /**
     * Return the block.
     *
     * @param string $blockName
     * @param mixed $default
     * @return string
     */
    public function write($blockName, $default = '')
    {
        if (isset($this->blocks[$blockName])) {
            return $this->blocks[$blockName];
        }
        return $default;
    }

    /**
     * Return the reserved block content.
     *
     * @return bool|string
     */
    public function writeContent()
    {
        return $this->write('_content');
    }

    /**
     * Define a template file that will be extended.
     *
     * @param string $template
     */
    public function extend($template)
    {
        if (file_exists($template)) {
            array_push($this->extendStack, $template);
        }
    }

    /**
     * Render de view.
     *
     * @param string $view
     * @param array $parameters
     * @return string
     */
    public function render($view, $parameters = array())
    {
        $this->extend($view);

        // Prevent some problem.
        unset($parameters['this']);

        extract($parameters, EXTR_SKIP);
        while (!empty($this->extendStack)) {
            $this->startBlock('_content');
            include array_pop($this->extendStack);
            $this->endBlock();
        }
        return $this->writeContent();
    }
}