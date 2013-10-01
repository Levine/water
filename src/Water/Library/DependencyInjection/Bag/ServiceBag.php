<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:32
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\SimpleBag;

/**
 * Class ServiceBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceBag extends SimpleBag
{
    const SERVICE_REGEX = '/^#([^#]+)$/';

    /**
     * Resolve service id and return the real id, FALSE if service not exist.
     *
     * @param string $service
     * @return mixed
     */
    public function resolve($service)
    {
        if (preg_match(self::SERVICE_REGEX, $service, $matches)) {
            return $matches[1];
        }
        return false;
    }
}