<?php
/**
 * User: Ivan C. Sanches
 * Date: 07/10/13
 * Time: 10:38
 */
namespace Water\Library\DependencyInjection\Tests\Resource\Fixture;

/**
 * Class TestServiceFactory
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestServiceFactory
{
    public function create($arg)
    {
        $test = new TestService();
        $test->setAttr($arg);

        return $test;
    }
}