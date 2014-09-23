<?php

namespace Fortune\FortuneApiBundle\Factory;

use Fortune\ResourceFactory as BaseFactory;
use Fortune\FortuneApiBundle\Output\SymfonyOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Fortune\Security\Security;
use Fortune\Security\Bouncer\ParentBouncer;
use Fortune\FortuneApiBundle\Security\SymfonyAuthenticationBouncer;
use Fortune\FortuneApiBundle\Security\SymfonyRoleBouncer;
use Fortune\FortuneApiBundle\Routing\SymfonyRouteGenerator;
use Fortune\Configuration\ResourceConfiguration;
use Fortune\FortuneApiBundle\Validator\SymfonyResourceValidator;
use Fortune\Validator\YamlResourceValidator;

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
            new ParentBouncer($config)
        );
    }

    protected function newValidator(ResourceConfiguration $config)
    {
        $class = $config->getValidatorClass();

        return $config->isUsingYamlValidation() ?
            new YamlResourceValidator($config->getYamlValidation())
            :
            new SymfonyResourceValidator(new $class(), $this->container->get('form.factory'))
            ;
    }
}
