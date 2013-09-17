<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 09:29
 */
namespace Water\Library\Kernel\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class RouteNotFoundException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class RouteNotFoundException extends NativeRuntimeException implements ExceptionInterface
{
}