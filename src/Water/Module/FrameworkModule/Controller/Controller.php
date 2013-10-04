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
}