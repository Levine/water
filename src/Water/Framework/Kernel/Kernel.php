<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 13:41
 */
namespace Water\Framework\Kernel;

use Water\Framework\Exception\InvalidModuleException;
use Water\Framework\Kernel\Module\ModuleInterface;
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
        $this->setOptions();
        $this->setParameters();

        $this->initialize();
    }

    /**
     * Initialize the current Kernel.
     */
    private function initialize()
    {
        $this->container = new ContainerBuilder();

        $this->extendContainer();

        $this->container->compile();
    }

    private function extendContainer()
    {
        foreach ($this->modules as $module) {
            if (!($module instanceof ModuleInterface)) {
                throw new InvalidModuleException(sprintf(
                    'The "%s", have to implement \Water\Framework\Module\ModuleInterface.',
                    (is_object($module)) ? get_class($module) : gettype($module)
                ));
            }

            $module->setContainer($this->container);

            $extensionName = str_replace('Module', 'Extension', $module->getShortName());
            $class         = $module->getNamespaceName() . '\\Extension\\' . $extensionName;

            if (class_exists($class, true)) {
                $extension = new $class();
                if (!($extension instanceof ContainerExtensionInterface)) {
                    // TODO - throw exception.
                }
                $extension->extend($this->container);
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
     * Define default options.
     */
    protected function setOptions()
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
}