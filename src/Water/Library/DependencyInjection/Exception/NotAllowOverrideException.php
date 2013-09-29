<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 17:25
 */
namespace Water\Library\DependencyInjection\Exception;

use \InvalidArgumentException as NativeInvalidArgumentException;

/**
 * Class NotAllowOverrideException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class NotAllowOverrideException extends NativeInvalidArgumentException implements ExceptionInterface
{
}