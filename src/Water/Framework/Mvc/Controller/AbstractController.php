<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 15:07
 */
namespace Water\Framework\Mvc\Controller;

use Water\Library\ServiceManager\ServiceLocatorAware;

/**
 * Class AbstractController
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class AbstractController extends ServiceLocatorAware
{
    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }
}