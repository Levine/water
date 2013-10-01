<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 10:51
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