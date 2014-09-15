<?php

namespace JFortunato\FortuneApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FortuneApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
