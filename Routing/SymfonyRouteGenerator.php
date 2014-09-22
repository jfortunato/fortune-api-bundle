<?php

namespace Fortune\FortuneApiBundle\Routing;

use Fortune\Routing\BaseRouteGenerator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Fortune\Configuration\ResourceConfiguration;

class SymfonyRouteGenerator extends BaseRouteGenerator implements LoaderInterface
{
    public function load($resource, $type = null)
    {
        return $this->generateRoutes();
    }

    public function supports($resource, $type = null)
    {
        return $type === 'api';
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
    }

    public function generateRoutes()
    {
        $routes = new RouteCollection;

        foreach ($this->configuration->getResourceConfigurations() as $resourceConfig) {
            $routes->add("list_{$resourceConfig->getResource()}", $this->generateGetAll($resourceConfig));
            $routes->add("show_{$resourceConfig->getResource()}", $this->generateGetSingle($resourceConfig));
            $routes->add("create_{$resourceConfig->getResource()}", $this->generatePost($resourceConfig));
            $routes->add("update_{$resourceConfig->getResource()}", $this->generatePut($resourceConfig));
            $routes->add("delete_{$resourceConfig->getResource()}", $this->generateDelete($resourceConfig));
        }

        return $routes;
    }

    protected function generateGetAll(ResourceConfiguration $config)
    {
        $defaults = array('_controller' => 'FortuneApiBundle:FortuneApi:index');

        return new Route($this->baseRoute($config), $defaults, array(), array(), '', array(), 'GET');
    }

    protected function generateGetSingle(ResourceConfiguration $config)
    {
        $defaults = array('_controller' => 'FortuneApiBundle:FortuneApi:show');

        $requirements = array('id' => '\d+');

        return new Route("{$this->baseRoute($config)}/{id}", $defaults, $requirements, array(), '', array(), 'GET');
    }

    protected function generatePost(ResourceConfiguration $config)
    {
        $defaults = array('_controller' => 'FortuneApiBundle:FortuneApi:create');

        return new Route($this->baseRoute($config), $defaults, array(), array(), '', array(), 'POST');
    }

    protected function generatePut(ResourceConfiguration $config)
    {
        $defaults = array('_controller' => 'FortuneApiBundle:FortuneApi:update');

        $requirements = array('id' => '\d+');

        return new Route("{$this->baseRoute($config)}/{id}", $defaults, $requirements, array(), '', array(), 'PUT');
    }

    protected function generateDelete(ResourceConfiguration $config)
    {
        $defaults = array('_controller' => 'FortuneApiBundle:FortuneApi:delete');

        $requirements = array('id' => '\d+');

        return new Route("{$this->baseRoute($config)}/{id}", $defaults, $requirements, array(), '', array(), 'DELETE');
    }

    protected function baseRoute(ResourceConfiguration $config)
    {
        $parent = $this->parentRoutesFor($config);

        return "{$parent}/{$config->getResource()}";
    }

    /**
     * Gets the parents routes for a given child resource.
     *
     * @param ResourceConfiguration $config
     * @return string
     */
    protected function parentRoutesFor(ResourceConfiguration $config)
    {
        if ($config->getParent()) {
            $parentConfig = $this->configuration->resourceConfigurationFor($config->getParent());

            return $this->parentRoutesFor($parentConfig) . "/{$config->getParent()}/{{$config->getParent()}_id}";
        }
    }
}
