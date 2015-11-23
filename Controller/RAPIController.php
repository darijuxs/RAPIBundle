<?php

namespace RAPIBundle\Controller;

use RAPIBundle\Request\Request;
use RAPIBundle\Response\Response;
use RAPIBundle\DataMapper\DataMapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RAPIController
 * @package RAPIBundle\Controller
 */
class RAPIController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var DataMapper
     */
    private $dataMapper;

    /**
     * @return Request
     */
    public function getRequest()
    {
        if ($this->request === null) {
            $this->request = $this->get('rapi.request');
        }

        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        if ($this->response === null) {
            $this->response = $this->get('rapi.response');
        }

        return $this->response;
    }

    /**
     * @return DataMapper
     */
    public function getDataMapper()
    {
        if ($this->dataMapper === null) {
            $this->dataMapper = $this->get('rapi.data_mapper');
        }

        return $this->dataMapper;
    }
}
