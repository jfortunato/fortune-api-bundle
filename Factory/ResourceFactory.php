<?php

namespace JFortunato\FortuneApiBundle\Factory;

use Fortune\ResourceFactory as BaseFactory;
use JFortunato\FortuneApiBundle\Output\SymfonyOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Fortune\Security\Security;
use Fortune\Security\Bouncer\ParentBouncer;
use JFortunato\FortuneApiBundle\Security\SymfonyAuthenticationBouncer;
use JFortunato\FortuneApiBundle\Security\SymfonyRoleBouncer;
use JFortunato\FortuneApiBundle\Security\SymfonyOwnerBouncer;
use JFortunato\FortuneApiBundle\Routing\SymfonyRouteGenerator;

class ResourceFactory extends BaseFactory
{
    protected $container;

    public function __construct(Container $container, EntityManager $manager, array $config)
    {
        $this->container = $container;

        parent::__construct($manager, $config);
    }

    public function newSymfonyOutput()
    {
        $config = $this->config->getCurrentResourceConfiguration();

        return new SymfonyOutput(
            $this->container->get('request'),
            new Response,
            $this->newSerializer($config),
            $this->newResource($config)
        );
    }

    public function newSymfonyRouteGenerator()
    {
        return new SymfonyRouteGenerator($this->config);
    }

    protected function newSecurity()
    {
        $config = $this->config->getCurrentResourceConfiguration();
        $security = $this->container->get('security.context');

        return new Security(
            new SymfonyAuthenticationBouncer($security, $config),
            new SymfonyRoleBouncer($security, $config),
            new SymfonyOwnerBouncer($config),
            new ParentBouncer($config)
        );
    }
}
