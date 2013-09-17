<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:36
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'path'     => '/',
                'resource' => array(
                    '_controller' => '\Water\Library\Kernel\Tests\Resource\Controller\IndexController::indexAction'
                )
            )
        )
    )
);
