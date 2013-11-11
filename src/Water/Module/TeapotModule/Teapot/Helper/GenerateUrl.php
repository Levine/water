<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/11/13
 * Time: 13:49
 */
namespace Water\Module\TeapotModule\Teapot\Helper;

use Water\Library\Router\RouterInterface;

/**
 * Class GenerateUrl
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class GenerateUrl
{
    /**
     * @var RouterInterface
     */
    private $router = null;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Generate a route by name.
     *
     * @param string $name
     * @return string
     */
    public function __invoke($name)
    {
        return $this->router->generate($name);
    }
}