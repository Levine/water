<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 13:41
 */
namespace Water\Framework\Kernel;

use Water\Framework\Kernel\Bag\ModuleBag;
use Water\Library\Bag\SimpleBag;
use Water\Library\DependencyInjection\ContainerBuilder;
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
    protected $httpKernel = null;

    /**
     * @var ContainerBuilder
     */
    protected $container = null;

    /**
     * @var bool
     */
    protected $compiled = false;

    /**
     * @var \ReflectionClass
     */
    protected $reflection = null;

    /**
     * @var SimpleBag
     */
    protected $config = array();

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var string
     */
    protected $environment = '';

    /**
     * @var bool
     */
    protected $debug = true;

    /**
     * @var ModuleBag
     */
    protected $modules = array();

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
        $this->modules     = new ModuleBag($this->registerModules());
        $this->setConfig();
        $this->setParameters();

        $this->initialize();
    }

    /**
     * Register modules used in the application.
     *
     * @return array
     */
    abstract public function registerModules();

    /**
     * Define default configurations.
     */
    protected function setConfig()
    {
        $configFile   = dirname($this->getReflection()->getFileName())
                      . '/config/application.' . $this->environment . '.config.php';
        $this->config = new SimpleBag((file_exists($configFile)) ? (array) include $configFile : array());
    }

    /**
     * Define default parameters.
     */
    protected function setParameters()
    {
        $this->parameters['kernel.environment'] = $this->environment;
        $this->parameters['kernel.debug']       = $this->debug;
        $this->parameters['kernel.dir']         = dirname($this->getReflection()->getFileName());
        $this->parameters['cache_dir']          = $this->parameters['kernel.dir'] . '/cache/' . $this->environment;
        $this->parameters['root_dir']           = dirname($this->parameters['kernel.dir']);
        $this->parameters['application_config'] = $this->config;
        $this->parameters = array_merge((array) $this->config->get('parameters', array()), $this->parameters);
    }

    /**
     * Initialize the current Kernel.
     */
    private function initialize()
    {
        $this->initializeModules();

        $this->initializeContainer();
    }

    /**
     * Initialize modules.
     */
    private function initializeModules()
    {
        $modules = array();
        foreach($this->getModules() as $module) {
            if (!preg_match('/^(?P<module>.+)Module$/', $module->getShortName(), $matches)) {
                throw new \InvalidArgumentException(sprintf(
                    'The class "%s" is do not has a valid module name. The module name has to end with Module.',
                    $module->getName()
                ));
            }
            $modules[$matches['module']] = $module;
        }
        $this->modules->fromArray($modules);
    }

    /**
     * Initialize container.
     */
    private function initializeContainer()
    {
        $this->container = $this->getContainer();
        $this->container->add('kernel', $this);
        $this->container->add('modules', $this->modules);
        $this->container->setParameters($this->parameters);
    }

    /**
     * @param Request $request
     * @param bool    $catch
     * @return Response
     */
    public function handle(Request $request, $catch = true)
    {
        $this->getContainer()->add('request', $request);

        if ($this->compiled === false) {
            $this->compile();
        }
        $response = $this->getHttpKernel()->handle($request, $catch);
        return $response;
    }

    /**
     * Compile the current container.
     */
    private function compile()
    {
        $this->buildModules();

        $this->container->compile();
        $this->compiled = true;
    }

    /**
     * Build modules.
     */
    private function buildModules()
    {
        $container = $this->getContainer();

        foreach ($this->getModules() as $name => $module) {
            $module->build($container);

            if (null !== $extension = $module->getExtension()) {
                $container->addExtension($name, $extension);
            }
        }
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
            $this->httpKernel = $this->getContainer()->get('http_kernel');
        }
        return $this->httpKernel;
    }

    // @codeCoverageIgnoreStart
    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        if ($this->container === null) {
            $this->container = new ContainerBuilder();
        }
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