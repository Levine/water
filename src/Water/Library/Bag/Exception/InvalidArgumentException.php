<?php
/**
 * User: Ivan C. Sanches
 * Date: 02/10/13
 * Time: 15:57
 */
namespace Water\Library\Bag\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalidArgumentException implements ExceptionInterface
{
}