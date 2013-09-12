<?php
/**
 * User: Ivan C. Sanches
 * Date: 11/09/13
 * Time: 22:06
 */
namespace Water\Library\Router\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalidArgumentException implements ExceptionInterface
{
}