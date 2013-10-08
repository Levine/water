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
     * @param string $name
     * @return string
     */
    public function generateUrl($name)
    {
        return $this->container->get('router')->generate($name);
    }

    /**
     * @param string $fileName
     * @param array  $parameters
     * @return Response
     */
    public function render($fileName, $parameters = array())
    {
        // TODO - review.
        $view = new View();
        return Response::create($view->render($fileName, (array) $parameters));
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->container->get('request');
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
}