<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 13:41
 */
namespace Water\Framework\Kernel;

use Water\Library\Bag\SimpleBag;
use Water\Library\Http\Request;
use Water\Library\Http\Response;
use Water\Library\Kernel\HttpKernelInterface;
use Water\Library\ServiceManager\ServiceManager;

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
     * @var ServiceManager
     */
    private $serviceManager = null;

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
        $this->setServiceManager();

        $this->extendServiceManager();
    }

    /**
     * Define the service manager instance.
     */
    private function setServiceManager()
    {
        $frameworkConfig = new SimpleBag($this->config->get('framework', array()));

        if ($frameworkConfig->has('service_manager.class')) {
            if (is_object($class = $frameworkConfig->get('service_manager.class'))) {
                $this->serviceManager = $class;
            } else {
                $this->serviceManager = new $class();
            }
        } else {
            $this->serviceManager = new ServiceManager();
        }
    }

    /**
     * Extend the container with Module extensions.
     */
    private function extendServiceManager()
    {

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
     * @return Kernel
     */
    protected function setOptions()
    {
        $configFile   = dirname($this->getReflection()->getFileName()) . '/config/application.config.php';
        $this->config = new SimpleBag((file_exists($configFile)) ? (array) include $configFile : array());
    }

    /**
     * @return Kernel
     */
    public function setParameters()
    {
        $this->parameters['kernel_environment'] = $this->environment;
        $this->parameters['kernel_debug']       = $this->debug;
        $this->parameters['kernel_dir']         = dirname($this->getReflection()->getFileName());
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
        return $this->httpKernel;
    }
}