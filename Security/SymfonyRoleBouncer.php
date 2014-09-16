<?php

namespace JFortunato\FortuneApiBundle\Security;

use Fortune\Security\Bouncer\RoleBouncer;
use Fortune\Configuration\ResourceConfiguration;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SymfonyRoleBouncer extends RoleBouncer
{
    protected $security;

    public function __construct(SecurityContextInterface $security, ResourceConfiguration $config)
    {
        $this->security = $security;

        parent::__construct($config);
    }

    public function hasRole($role)
    {
        return $this->security->isGranted($role);
    }
}
