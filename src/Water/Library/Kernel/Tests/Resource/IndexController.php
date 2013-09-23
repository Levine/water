<?php
/**
 * User: Ivan C. Sanches
 * Date: 23/09/13
 * Time: 10:53
 */
namespace Water\Library\Kernel\Tests\Resource;

use Water\Library\Http\Response;

/**
 * Class IndexController
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class IndexController
{
    public function indexAction()
    {
        return Response::create('Test');
    }
}