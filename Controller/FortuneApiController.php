<?php

namespace JFortunato\FortuneApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JFortunato\FortuneApiBundle\Output\SymfonyOutput;
use Symfony\Component\HttpFoundation\Response;

class FortuneApiController extends Controller
{
    public function indexAction($parentId = null)
    {
        return $this->getOutput()->index($parentId);
    }

    public function showAction($id, $parentId = null)
    {
        return $this->getOutput()->show($id, $parentId);
    }

    public function createAction($parentId = null)
    {
        return $this->getOutput()->create($parentId);
    }

    public function updateAction($id, $parentId = null)
    {
        return $this->getOutput()->update($id, $parentId);
    }

    public function deleteAction($id, $parentId = null)
    {
        return $this->getOutput()->delete($id, $parentId);
    }

    protected function getOutput()
    {
        return $this->container->get('fortune_api.output');
    }
}
