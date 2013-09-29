<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 16:16
 */
namespace Water\Library\DependencyInjection\Tests\Resource;

/**
 * Class Service
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Service
{
    public $arg1 = 0;
    public $arg2 = 0;

    public function __construct($arg1, $arg2)
    {
        $this->arg1 = $arg1;
        $this->arg2 = $arg2;
    }

    /**
     * @param int $arg1
     * @return Service
     */
    public function setArg1($arg1)
    {
        $this->arg1 = $arg1;
        return $this;
    }

    /**
     * @param int $arg2
     * @return Service
     */
    public function setArg2($arg2)
    {
        $this->arg2 = $arg2;
        return $this;
    }
}