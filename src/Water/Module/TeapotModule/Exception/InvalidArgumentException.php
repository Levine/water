<?php
/**
 * User: Ivan C. Sanches
 * Date: 06/11/13
 * Time: 15:06
 */
namespace Water\Module\TeapotModule\Exception;

use \InvalidArgumentException as NativeInvalideArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class InvalidArgumentException extends NativeInvalideArgumentException implements ExceptionInterface
{
} 