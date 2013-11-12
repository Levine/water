<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:56
 */
namespace Water\Library\Router;

use Water\Library\Router\Context\RequestContext;
use Water\Library\Router\Generator\GeneratorInterface;
use Water\Library\Router\Matcher\MatcherInterface;

/**
 * Class Router
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @var RouteCollection
     */
    protected $routes = null;

    /**
     * @var MatcherInterface
     */
    protected $matcher = null;

    /**
     * @var GeneratorInterface
     */
    protected $generator = null;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * {@inheritdoc}
     */
    public function __construct(RouteCollection $routes = null, array $options = array())
    {
        $this->routes = $routes;
        $this->setOptions($options);
    }

    /**
     * Define default options.
     *
     * @param array $options
     */
    private function setOptions(array $options)
    {
        $default = array(
            'generator_class'   => 'Water\Library\Router\Generator\UrlGenerator',
            'matcher_class'     => 'Water\Library\Router\Matcher\UrlMatcher',
        );

        $this->options = array_merge($default, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function match($path)
    {
        return $this->getMatcher()->match($path);
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name)
    {
        return $this->getGenerator()->generate($name);
    }

    /**
     * @return MatcherInterface
     *
     * @throws \InvalidArgumentException
     */
    private function getMatcher()
    {
        if ($this->matcher !== null) {
            return $this->matcher;
        }

        if (!is_a($this->options['matcher_class'], '\Water\Library\Router\Matcher\UrlMatcherInterface', true)) {
            throw new \InvalidArgumentException(
                'The option "matcher_class" has to be a instance of "Water\Library\Router\Matcher\MatcherInterface".'
            );
        }

        return $this->matcher = new $this->options['matcher_class']($this->getRoutes());
    }

    /**
     * @return GeneratorInterface
     *
     * @throws \InvalidArgumentException
     */
    private function getGenerator()
    {
        if ($this->generator !== null) {
            return $this->generator;
        }

        if (!is_a($this->options['generator_class'], '\Water\Library\Router\Generator\UrlGeneratorInterface', true)) {
            throw new \InvalidArgumentException(
                'The option "generator_class" has to be a instance of "Water\Library\Router\Generator\GeneratorInterface".'
            );
        }

        return $this->generator = new $this->options['generator_class']($this->getRoutes());
    }

    /**
     * @return \Water\Library\Router\RouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
