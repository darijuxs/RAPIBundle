<?php

namespace RAPIBundle\Listener;

use RAPIBundle\Response\HttpStatusCode;
use RAPIBundle\Response\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 * @package RAPIBundle\Listener
 */
class ExceptionListener
{
    const ENVIRONMENT_DEV = "dev";
    const ENVIRONMENT_PROD = "prod";

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var string
     */
    private $environment;

    /**
     * ExceptionListener constructor
     *
     * @param RequestStack $requestStack
     * @param $environment
     */
    public function __construct(RequestStack $requestStack, $environment)
    {
        $this->request = $requestStack;
        $this->environment = $environment;
    }

    /**
     * Return exception response in JSON format
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (self::ENVIRONMENT_DEV == $this->environment) {
            return;
        }

        $exception = $event->getException();
        $event->setResponse(
            (new Response($this->request))
                ->setStatusCode(HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR)
                ->setError($exception->getMessage())
                ->get()
        );
    }
}
