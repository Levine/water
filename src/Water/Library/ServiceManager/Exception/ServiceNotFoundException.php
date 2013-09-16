<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 14:02
 */
namespace Water\Library\ServiceManager\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class ServiceNotFoundException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceNotFoundException extends NativeRuntimeException implements ExceptionInterface
{
}