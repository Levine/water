<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 14:25
 */
namespace Water\Library\DependencyInjection\Tests\Resource\Fixture;

/**
 * Class TestService
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TestService
{
    public $attr = 0;

    public function setAttr($attr)
    {
        $this->attr = $attr;
        return $this;
    }
}