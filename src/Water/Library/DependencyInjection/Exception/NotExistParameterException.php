<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 10:03
 */
namespace Water\Library\DependencyInjection\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class NotExistParameterException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class NotExistParameterException extends NativeRuntimeException implements ExceptionInterface
{
}