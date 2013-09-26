<?php
/**
 * User: Ivan C. Sanches
 * Date: 26/09/13
 * Time: 13:41
 */
namespace Water\Framework\Kernel;

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
     * @var \ReflectionClass
     */
    private $reflection = null;

    /**
     * @var array
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
     * @var array
     */
    private $modules = array();

    /**
     * Constructor.
     *
     * @param string $environment
     */
    public function __construct($environment = 'dev')
    {
        $this->environment = $environment;
        $this->modules     = $this->registerModules();
        $this->setOptions();
        $this->setParameters();
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
        $this->config = (file_exists($configFile)) ? include $configFile : array();
    }

    /**
     * @return Kernel
     */
    public function setParameters()
    {
        $this->parameters['kernel_environment'] = $this->environment;
        $this->parameters['kernel_dir']         = dirname($this->getReflection()->getFileName());
        $this->parameters['root_dir']           = dirname($this->parameters['kernel_dir']);
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