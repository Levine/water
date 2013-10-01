<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 14:23
 */
namespace Water\Library\DependencyInjection\Tests\Resource\Fixture;

/**
 * Class TestServiceWithConstructor
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestServiceWithConstructor
{
    public $attr = 0;
    public $service = null;

    public function __construct($attr, TestService $service)
    {
        $this->attr    = $attr;
        $this->service = $service;
    }
}