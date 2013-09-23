<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 22:41
 */
namespace Water\Library\Kernel\Exception;

use \LogicException as NativeLogicException;

/**
 * Class LogicException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class LogicException extends NativeLogicException implements ExceptionInterface
{
}