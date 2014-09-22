<?php

namespace Fortune\FortuneApiBundle\Output;

use Fortune\Output\BaseOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fortune\Serializer\SerializerInterface;
use Fortune\ResourceInterface;

class SymfonyOutput extends BaseOutput
{
    protected $request;

    protected $response;

    public function __construct(
        Request $request,
        Response $response,
        SerializerInterface $serializer,
        ResourceInterface $resource
    ) {
        $this->request = $request;
        $this->response = $response;

        parent::__construct($serializer, $resource);
    }

    protected function setJsonHeader()
    {
        $this->response->headers->set('Content-Type', 'application/json');
    }

    protected function setStatusCode($code)
    {
        $this->response->setStatusCode($code);
    }

    protected function content($serializedContent)
    {
        $this->response->setContent($serializedContent);
        
        return $this->response;
    }

    protected function getInput()
    {
        return $this->request->request->all();
    }
}
