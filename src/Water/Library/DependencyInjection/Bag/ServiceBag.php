<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 14:32
 */
namespace Water\Library\DependencyInjection\Bag;

use Water\Library\Bag\StronglyTypedBag;
use Water\Library\Bag\Type\ObjectType;
use Water\Library\Bag\Type\TypeInterface;

/**
 * Class ServiceBag
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class ServiceBag extends StronglyTypedBag
{
    const SERVICE_REGEX = '/^#([^#]+)$/';

    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct(array $input = array())
    {
        parent::__construct(new ObjectType(), $input);
    }

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