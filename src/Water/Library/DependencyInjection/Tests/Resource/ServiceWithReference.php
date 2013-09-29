<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 10:53
 */
namespace Water\Library\DependencyInjection\Tests\Resource;

/**
 * Class ServiceWithReference
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceWithReference
{
    public $service = null;
    public $attr    = '';

    public function __construct(Service $service, $attr)
    {
        $this->service = $service;
        $this->attr    = $attr;
    }
}