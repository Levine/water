<?php
/**
 * User: Ivan C. Sanches
 * Date: 30/09/13
 * Time: 16:35
 */
namespace Water\Library\DependencyInjection\CompileProcessor\Process;

use Water\Library\DependencyInjection\ContainerBuilderInterface;

/**
 * Interface ProcessInterface
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
interface ProcessInterface
{
    /**
     * @param ContainerBuilderInterface $container
     */
    public function process(ContainerBuilderInterface $container);
}