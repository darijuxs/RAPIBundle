<?php

namespace RAPIBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Response
 * @package RAPIBundle\Response
 */
class Response extends JsonResponse
{
    const STATUS = 'status';
    const CODE = 'code';
    const INFO = 'info';
    const RESULT = 'result';
    const ERRORS = 'errors';
    const ERROR_MESSAGE = 'error';
    const CUSTOM_RESULT = 'customResult';
    const PROFILER = 'profiler';
    /**
     * @var int
     */
    protected $statusCode;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $total;
    /**
     * @var int
     */
    private $pages;
    /**
     * @var string|array|null
     */
    private $customResponse;
    /**
     * @var array
     */
    private $errors = [];
    /**
     * @var array|null
     */
    private $result;

    /**
     * @var
     */
    private $profiler;

    public function __construct()
    {
        parent::__construct();

        $this->statusCode = HttpStatusCode::HTTP_OK;

        $this->headers->set('X-Status-Code', 200);
        $this->headers->set('Access-Control-Allow-Origin', '*');
        $this->headers->set('Access-Control-Allow-Credentials', 'true');
        $this->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $this->headers->set('Access-Control-Max-Age', '604800');
        $this->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    }

    /**
     * @param int $statusCode
     * @param null $text
     * @return $this
     */
    public function setStatusCode($statusCode, $text = null)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param array $result
     * @return $this
     */
    public function setResult(array $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Set custom response
     *
     * @param $response
     * @return $this
     */
    public function setCustomResponse($response)
    {
        $this->customResponse = $response;

        return $this;
    }

    /**
     * How many pages
     *
     * @param $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;

        return $this;
    }

    /**
     * How many records is, for padding.
     *
     * @param $limit
     * @return $this
     */
    public function setTotal($limit)
    {
        $this->total = (int)$limit;

        return $this;
    }

    /**
     * How many pages exists, for padding
     *
     * @param $limit
     * @return $this
     */
    public function setPages($limit)
    {
        $this->pages = (int)$limit;

        return $this;
    }

    /**
     * @param $error
     * @return $this
     */
    public function setError($error)
    {
        $this->errors[] = $error;

        return $this;
    }

    public function setProfiler($profiler)
    {
        $this->profiler = $profiler;

        return $this;
    }

    /**
     * Get response
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function get()
    {
        return $this->setData($this->createStructure());
    }

    /**
     * Create response structure from object data
     * @return array
     */
    public function createStructure()
    {
        $array = [
            self::STATUS => [
                self::CODE => $this->statusCode
            ],
            self::RESULT => $this->result
        ];

        //When error happens
        if ($this->statusCode > 399) {
            $array[self::ERROR_MESSAGE] = [
                self::ERRORS => $this->errors
            ];

            $array[self::RESULT] = null;
        }

        if ($this->customResponse) {
            $array[self::CUSTOM_RESULT] = $this->customResponse;
        }

        //Extra information for padding
        $array[self::INFO] = [
            'total' => $this->total,
            'page' => $this->pages,
            'limit' => $this->limit,
        ];

        if ($this->profiler) {
            $array[self::PROFILER] = $this->profiler;
        }

        return $array;
    }
}
