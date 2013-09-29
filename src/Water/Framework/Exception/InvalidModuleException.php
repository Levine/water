<?php
/**
 * User: Ivan C. Sanches
 * Date: 29/09/13
 * Time: 14:05
 */
namespace Water\Framework\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class InvalidModuleException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidModuleException extends NativeRuntimeException implements ExceptionInterface
{
}