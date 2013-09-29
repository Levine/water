<?php
/**
 * User: Ivan C. Sanches
 * Date: 28/09/13
 * Time: 21:59
 */
namespace Water\Library\DependencyInjection\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalidArgumentException implements ExceptionInterface
{
}