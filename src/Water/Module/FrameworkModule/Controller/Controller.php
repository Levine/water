<?php
/**
 * User: Ivan C. Sanches
 * Date: 04/10/13
 * Time: 14:35
 */
namespace Water\Module\FrameworkModule\Controller;

use Water\Library\DependencyInjection\ContainerAware;
use Water\Library\Http\RedirectResponse;
use Water\Library\Http\Request;
use Water\Library\Http\Response;
use Water\Library\View\View;

/**
 * Class Controller
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
abstract class Controller extends ContainerAware
{
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * @param string $name
     * @return Doctrine\ORM\EntityManager|null
     */
    public function getDoctrine($name = 'default')
    {
        if ($this->container->has('doctrine')){
            return $this->container->get('doctrine')->get($name);
        }
        return null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return $this->container->has($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->container->get($name);
    }

    /**
     * @param string $name
     * @return string
     */
    public function generateUrl($name)
    {
        return $this->container->get('router')->generate($name);
    }

    /**
     * @param string $template
     * @param array  $parameters
     * @return Response
     */
    public function render($template, $parameters = array())
    {
        $content = $this->container->get('template_render')->render($template, (array) $parameters);
        return Response::create($content);
    }

    /**
     * Redirect to specified url.
     *
     * @param string $url
     * @return RedirectResponse
     */
    public function redirect($url)
    {
        return new RedirectResponse($url);
    }
}