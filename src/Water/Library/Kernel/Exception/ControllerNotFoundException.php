<?php
/**
 * User: Ivan C. Sanches
 * Date: 17/09/13
 * Time: 13:13
 */
namespace Water\Library\Kernel\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class ControllerNotFoundException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ControllerNotFoundException extends NativeRuntimeException implements ExceptionInterface
{
}