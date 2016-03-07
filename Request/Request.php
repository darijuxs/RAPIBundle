<?php

namespace RAPIBundle\Request;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Request
 * @package RAPIBundle\Request
 */
class Request
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var null|array $content
     */
    private $content;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $name
     * @return string|array|null
     */
    public function get($name)
    {
        $content = $this->getData();
        return (isset($content[$name])) ? $content[$name] : null;
    }

    /**
     * @return array|null JSON|POST data
     */
    public function getData()
    {
        if (null === $this->content) {
            $this->content = $this->getJsonData() ?: $this->getPostData();
        }

        return $this->content;
    }

    /**
     * @return array|null JSON data
     */
    public function getJsonData()
    {
        return json_decode($this->requestStack->getCurrentRequest()->getContent(), true);
    }

    /**
     * @return array|null POST data
     */
    public function getPostData()
    {
        $request = $this->requestStack->getCurrentRequest()->request->all();
        return (is_array($request) && count($request)) ? $request : null;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }
}
