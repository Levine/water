<?php
/**
 * User: Ivan C. Sanches
 * Date: 21/08/13
 * Time: 22:41
 */
namespace Water\Library\HttpProtocol;

/**
 * Class Request
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class Request
{
    /**
     * @var array
     */
    private $server = array();

    /**
     * @var array
     */
    private $queryData = array();

    /**
     * @var array
     */
    private $postData = array();
}
