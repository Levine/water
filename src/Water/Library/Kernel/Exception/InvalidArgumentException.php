<?php
/**
 * User: Ivan C. Sanches
 * Date: 22/09/13
 * Time: 22:07
 */
namespace Water\Library\Kernel\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalidArgumentException implements ExceptionInterface
{
}