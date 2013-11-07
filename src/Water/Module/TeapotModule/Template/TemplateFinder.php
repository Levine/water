<?php
/**
 * User: Ivan C. Sanches
 * Date: 07/11/13
 * Time: 10:26
 */
namespace Water\Module\TeapotModule\Template;

use \ReflectionClass;
use Water\Framework\Kernel\Bag\ModuleBag;
use Water\Framework\Kernel\Module\ModuleInterface;
use Water\Library\DependencyInjection\ContainerInterface;
use Water\Module\TeapotModule\Exception\InvalidArgumentException;

/**
 * Class TemplateFinder
 *
 * @author Ivan C. Sanches <ics89@hotmail.com>
 */
class TemplateFinder implements TemplateFinderInterface
{
    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function find(array $controller)
    {
        $class  = get_class($controller[0]);
        $method = $controller[1];

        if (!preg_match('/Controller\\\(?P<controller>.+)Controller$/', $class, $match)) {
            throw new InvalidArgumentException(sprintf(
                'The class "%s" does not look like a controller class '
                . '(Example: <ModuleNamespace>\\Controller\\<ControllerName>Controller).',
                $class
            ));
        }

        $module  = $this->getModule($class, $this->container->get('modules'));
        $template = substr($module->getShortName(), 0, -6) . '::'
                  . $match['controller'] . '::'
                  . $method;

        return $template;
    }

    /**
     * @param string    $class
     * @param ModuleBag $modules
     * @return ModuleInterface
     *
     * @throws InvalidArgumentException
     */
    private function getModule($class, ModuleBag $modules)
    {
        $refController = new ReflectionClass($class);
        $namespace     = $refController->getNamespaceName();
        foreach ($modules as $module) {
            if (strpos($namespace, $module->getNamespaceName()) === 0) {
                return $module;
            }
        }

        throw new InvalidArgumentException(sprintf(
            'The controller "%s" not belongs to any registered module.',
            $refController->getName()
        ));
    }
}