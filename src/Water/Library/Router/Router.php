<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/08/13
 * Time: 15:56
 */
namespace Water\Library\Router;

use Water\Library\Router\Exception\InvalidArgumentException;
use Water\Library\Router\Generator\GeneratorInterface;
use Water\Library\Router\Matcher\MatcherInterface;

/**
 * Class Router
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Router
{
    /**
     * @var RouteCollection
     */
    private $routes = null;

    /**
     * @var MatcherInterface
     */
    private $matcher = null;

    /**
     * @var GeneratorInterface
     */
    private $generator = null;

    /**
     * @var array
     */
    private $options = array();

    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     * @param array           $options
     */
    public function __construct(RouteCollection $routes, array $options = array())
    {
        $this->routes = $routes;
        $this->setOptions($options);
    }

    private function setOptions(array $options)
    {
        $default = array(
            'generator_class'   => 'Water\Library\Router\Generator\UrlGenerator',
            'matcher_class'     => 'Water\Library\Router\Matcher\UrlMatcher',
        );

        $this->options = array_merge($default, $options);
    }

    /**
     * @see \Water\Library\Router\Matcher\MatcherInterface::match($path)
     */
    public function match($path)
    {
        return $this->getMatcher()->match($path);
    }

    /**
     * @see \Water\Library\Router\Generator\GeneratorInterface::generate($name)
     */
    public function generate($name)
    {
        return $this->getGenerator()->generate($name);
    }

    /**
     * @return MatcherInterface
     *
     * @throws InvalidArgumentException
     */
    private function getMatcher()
    {
        if ($this->matcher !== null) {
            return $this->matcher;
        }

        if (!is_a($this->options['matcher_class'], '\Water\Library\Router\Matcher\MatcherInterface', true)) {
            throw new InvalidArgumentException(
                'The option "matcher_class" has to be a instance of "Water\Library\Router\Matcher\MatcherInterface".'
            );
        }

        return $this->matcher = new $this->options['matcher_class']($this->routes);
    }

    /**
     * @return GeneratorInterface
     *
     * @throws InvalidArgumentException
     */
    private function getGenerator()
    {
        if ($this->generator !== null) {
            return $this->generator;
        }

        if (!is_a($this->options['generator_class'], '\Water\Library\Router\Generator\GeneratorInterface', true)) {
            throw new InvalidArgumentException(
                'The option "generator_class" has to be a instance of "Water\Library\Router\Generator\GeneratorInterface".'
            );
        }

        return $this->generator = new $this->options['generator_class']($this->routes);
    }

    // @codeCoverageIgnoreStart
    /**
     * @return \Water\Library\Router\RouteCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }
    // @codeCoverageIgnoreEnd
}
