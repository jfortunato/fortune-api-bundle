<?php

namespace Fortune\FortuneApiBundle\Validator;

use Fortune\Validator\ResourceValidatorInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormFactoryInterface;

class SymfonyResourceValidator implements ResourceValidatorInterface
{
    protected $formType;

    protected $factory;

    public function __construct(FormTypeInterface $formType, FormFactoryInterface $factory)
    {
        $this->formType = $formType;
        $this->factory = $factory;
    }

    public function validate(array $input, array $existing = array())
    {
        $form = $this->factory->create($this->formType, $existing, array('csrf_protection' => false));

        return $form->submit($input, true)->isValid();
    }
}
