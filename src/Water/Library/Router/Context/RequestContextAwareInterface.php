<?php
/**
 * User: Ivan C. Sanches
 * Date: 09/09/13
 * Time: 16:24
 */
namespace Water\Library\Router\Context;

/**
 * Interface RequestContextAwareInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface RequestContextAwareInterface
{
    /**
     * @param RequestContext $context
     */
    public function setRequestContext(RequestContext $context);
}