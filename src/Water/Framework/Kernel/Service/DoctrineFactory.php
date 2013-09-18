<?php
/**
 * User: Ivan C. Sanches
 * Date: 18/09/13
 * Time: 14:10
 */
namespace Water\Framework\Kernel\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Water\Library\ServiceManager\FactoryInterface;
use Water\Library\ServiceManager\ServiceLocatorInterface;

/**
 * Class DoctrineFactory
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class DoctrineFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(ServiceLocatorInterface $sm = null)
    {
        $appConfig = $sm->get('appConfig');

        $doctrineConfig = (isset($appConfig['doctrine'])) ? $appConfig['doctrine'] : array();

        if (empty($doctrineConfig)) {
            return null;
        }

        $config = new Configuration();

        if ($sm->get('_environment') == 'dev') {
            $config->setAutoGenerateProxyClasses(true);
            $cache = new ArrayCache();
        } else {
            $config->setAutoGenerateProxyClasses(false);
            $cache = (function_exists('apc_store')) ? new ApcCache() : new ArrayCache();
        }
        $config->setMetadataCacheImpl($cache);
        $driverImpl = new AnnotationDriver(new AnnotationReader(), (array) $doctrineConfig['entity_paths']);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir($doctrineConfig['proxy_dir']);
        $config->setProxyNamespace($doctrineConfig['proxy_namespace']);

        // Namespace alias.
        $config->setEntityNamespaces($doctrineConfig['entity_namespaces']);

        return EntityManager::create($doctrineConfig['database'], $config);
    }
}