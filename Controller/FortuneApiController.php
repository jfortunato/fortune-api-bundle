<?php

namespace Fortune\FortuneApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fortune\FortuneApiBundle\Output\SymfonyOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FortuneApiController extends Controller
{
    public function indexAction()
    {
        return $this->execute('index');
    }

    public function showAction()
    {
        return $this->execute('show');
    }

    public function createAction()
    {
        return $this->execute('create');
    }

    public function updateAction()
    {
        return $this->execute('update');
    }

    public function deleteAction()
    {
        return $this->execute('delete');
    }

    protected function getOutput()
    {
        return $this->container->get('fortune_api.output');
    }

    /**
     * Symfony requires a set number of parameters for a controller method,
     * but be need an unlimited number. This method fetches all the resource
     * identifiers (if any) from the request uri and returns them in an array.
     *
     * @return array
     */
    protected function getIdentifiers()
    {
        $request = $this->container->get('request');

        $pathInfo = explode('/', trim($request->getPathInfo(), '/'));

        $identifiers = array();
        foreach ($pathInfo as $key => $value) {
            if ($key % 2) {
                $identifiers[] = $value;
            }
        }

        return $identifiers;
    }

    protected function execute($method)
    {
        $identifiers = $this->getIdentifiers();

        return call_user_func_array(array($this->getOutput(), $method), $identifiers);
    }
}
