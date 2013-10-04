<?php
/**
 * User: Ivan C. Sanches
 * Date: 27/09/13
 * Time: 15:53
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;

/**
 * Class ParameterBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ParameterBag extends SimpleBag
{
    const PARAMETER_REGEX = '/^%([^%]+)%$/';


    /**
     * Resolve name and return the real index, FALSE if index not exist.
     *
     * @param string $name
     * @return mixed
     */
    public function resolve($name)
    {
        if (is_string($name) && preg_match(self::PARAMETER_REGEX, $name, $matches)) {
            return $matches[1];
        }
        return false;
    }
}