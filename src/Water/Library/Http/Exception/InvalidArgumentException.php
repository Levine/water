<?php
/**
 * User: Ivan C. Sanches
 * Date: 25/09/13
 * Time: 15:39
 */
namespace Water\Library\Http\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalidArgumentException implements ExceptionInterface
{
}