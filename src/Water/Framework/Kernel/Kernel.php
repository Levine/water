<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 13:41
 */
namespace Water\Framework\Kernel;

use Water\Framework\Exception\InvalidContainerExtensionException;
use Water\Framework\Exception\InvalidModuleException;
use Water\Framework\Module\ModuleInterface;
use Water\Library\Bag\SimpleBag;
use Water\Library\DependencyInjection\ContainerBuilder;
use Water\Library\DependencyInjection\ContainerExtensionInterface;
use Water\Library\Http\Request;
use Water\Library\Http\Response;
use Water\Library\Kernel\HttpKernelInterface;

/**
 * Class Kernel
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
abstract class Kernel
{
    /**
     * @var HttpKernelInterface
     */
    private $httpKernel = null;

    /**
     * @var ContainerBuilder
     */
    private $container = null;

    /**
     * @var \ReflectionClass
     */
    private $reflection = null;

    /**
     * @var SimpleBag
     */
    private $config = array();

    /**
     * @var array
     */
    private $parameters = array();

    /**
     * @var string
     */
    private $environment = '';

    /**
     * @var bool
     */
    private $debug = true;

    /**
     * @var array
     */
    private $modules = array();

    /**
     * Constructor.
     *
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($environment = 'dev', $debug = true)
    {
        $this->environment = (string) $environment;
        $this->debug       = (boolean) $debug;
        $this->modules     = (array) $this->registerModules();
        $this->setConfig();
        $this->setParameters();

        $this->initialize();
    }

    /**
     * Initialize the current Kernel.
     */
    private function initialize()
    {
        $this->container = (isset($this->parameters['service_container.class']))
                         ? new $this->parameters['service_container.class']()
                         : new ContainerBuilder();
        $this->container->set('kernel', $this);
        $this->container->setParameters($this->parameters);

        $this->extendContainer();

        $this->container->compile();
    }

    /**
     * Extend the current container with modules definitions.
     *
     * @throws InvalidModuleException
     */
    private function extendContainer()
    {
        foreach ($this->modules as $module) {
            if (!is_a($module, '\Water\Framework\Module\ModuleInterface')) {
                throw new InvalidModuleException(sprintf(
                    'The module "%s", have to implement \Water\Framework\Module\ModuleInterface.',
                    (is_object($module)) ? get_class($module) : gettype($module)
                ));
            }

            $module->setContainer($this->container);

            $extensionName = str_replace('Module', 'Extension', $module->getShortName());
            $class         = $module->getNamespaceName() . '\\Extension\\' . $extensionName;

            if (class_exists($class, true)) {
                $extension = new $class();
                if (is_a($extension, '\Water\Library\DependencyInjection\ContainerExtensionInterface')) {
                    $extension->extend($this->container);
                }
            }
        }
    }

    /**
     * Register modules used in the application.
     *
     * @return array
     */
    abstract public function registerModules();

    /**
     * @param Request $request
     * @param bool $catch
     * @return Response
     */
    public function handle(Request $request, $catch = true)
    {
        return $this->getHttpKernel()->handle($request, $catch);
    }

    /**
     * Define default configurations.
     */
    protected function setConfig()
    {
        $configFile   = dirname($this->getReflection()->getFileName()) . '/config/application.config.php';
        $this->config = new SimpleBag((file_exists($configFile)) ? (array) include $configFile : array());
    }

    /**
     * Define default parameters.
     */
    protected function setParameters()
    {
        $this->parameters['kernel_environment'] = $this->environment;
        $this->parameters['kernel_debug']       = $this->debug;
        $this->parameters['kernel_dir']         = dirname($this->getReflection()->getFileName());
        $this->parameters['cache_dir']          = $this->parameters['kernel_dir'] . '/cache/' . $this->environment;
        $this->parameters['root_dir']           = dirname($this->parameters['kernel_dir']);
        $this->parameters = array_merge((array) $this->config->get('parameters', array()), $this->parameters);
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflection()
    {
        if ($this->reflection === null) {
            $this->reflection = new \ReflectionClass($this);
        }
        return $this->reflection;
    }

    /**
     * @return HttpKernelInterface
     */
    public function getHttpKernel()
    {
        if ($this->httpKernel === null) {
            $this->httpKernel = $this->container->get('http_kernel');
        }
        return $this->httpKernel;
    }

    // @codeCoverageIgnoreStart
    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Water\Library\Bag\SimpleBag
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    // @codeCoverageIgnoreEnd
}