<?php

namespace JFortunato\FortuneApiBundle\Security;

use Fortune\Security\Bouncer\OwnerBouncer;
use Fortune\Configuration\ResourceConfiguration;

class SymfonyOwnerBouncer extends OwnerBouncer
{
    public function __construct(ResourceConfiguration $config)
    {
        parent::__construct($config);
    }

    public function isOwner()
    {
    }
}
