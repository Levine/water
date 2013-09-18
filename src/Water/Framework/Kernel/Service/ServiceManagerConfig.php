<?php
/**
 * User: Ivan C. Sanches
 * Date: 18/09/13
 * Time: 15:36
 */
namespace Water\Framework\Kernel\Service;

use Water\Library\Kernel\Service\ServiceManagerConfig as Configuration;

/**
 * Class ServiceManagerConfig
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceManagerConfig extends Configuration
{
    /**
     * @var array
     */
    protected $factories = array(
        'resolver'      => '\Water\Library\Kernel\Service\ControllerResolverFactory',
        'router'        => '\Water\Library\Kernel\Service\RouterFactory',

        'doctrine'      => '\Water\Framework\Kernel\Service\DoctrineFactory',
    );

    /**
     * @var array
     */
    protected $instantiables = array();

    /**
     * @var array
     */
    protected $alias = array();
}