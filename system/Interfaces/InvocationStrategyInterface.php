<?php

namespace System\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Defines a contract for invoking a route callable.
 */
interface InvocationStrategyInterface
{
    /**
     * Invoke a route callable.
     *
     * @param callable               $callable       The callable to invoke using the strategy.
     * @param ServerRequestInterface $request        The request object.
     * @param ResponseInterface      $response       The response object.
     * @param array                  $routeArguments The route's placholder arguments
     *
     * @return ResponseInterface|string The response from the callable.
     */
    public function __invoke (
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    );
}
