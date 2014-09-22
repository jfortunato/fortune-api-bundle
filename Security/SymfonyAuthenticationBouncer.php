<?php

namespace Fortune\FortuneApiBundle\Security;

use Fortune\Security\Bouncer\AuthenticationBouncer;
use Fortune\Configuration\ResourceConfiguration;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SymfonyAuthenticationBouncer extends AuthenticationBouncer
{
    protected $security;

    public function __construct(SecurityContextInterface $security, ResourceConfiguration $config)
    {
        $this->security = $security;

        parent::__construct($config);
    }

    public function isAuthenticated()
    {
        return $this->security->isGranted('IS_AUTHENTICATED_FULLY');
    }
}
