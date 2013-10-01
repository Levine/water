<?php
/**
 * User: Ivan C. Sanches
 * Date: 01/10/13
 * Time: 09:59
 */
namespace Water\Library\DependencyInjection\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class NotExistServiceException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class NotExistServiceException extends NativeRuntimeException implements ExceptionInterface
{
}