<?php
/**
 * User: Ivan C. Sanches
 * Date: 16/09/13
 * Time: 14:57
 */
namespace Water\Library\ServiceManager\Exception;

use \RuntimeException as NativeRuntimeException;

/**
 * Class ServiceOverrideDisabledException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceOverrideDisabledException extends NativeRuntimeException implements ExceptionInterface
{
}