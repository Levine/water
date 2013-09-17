<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:38
 */
namespace Water\Library\Kernel\Tests\Resource\Controller;
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