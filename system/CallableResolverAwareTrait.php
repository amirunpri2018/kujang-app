<?php

namespace System;

use Psr\Container\ContainerInterface;
use RuntimeException;
use System\Interfaces\CallableResolverInterface;

/**
 * ResolveCallable
 *
 * This is an internal class that enables resolution of 'class:method' strings
 * into a closure. This class is an implementation detail and is used only inside
 * of the System application.
 *
 * @property ContainerInterface $container
 */
trait CallableResolverAwareTrait
{
    /**
     * Resolve a string of the format 'class:method' into a closure that the
     * router can dispatch.
     *
     * @param callable|string $callable
     *
     * @return \Closure
     *
     * @throws RuntimeException If the string cannot be resolved as a callable
     */
    protected function resolveCallable ( $callable )
    {
        if ( !$this->container instanceof ContainerInterface ) {
            return $callable;
        }
        
        /** @var CallableResolverInterface $resolver */
        $resolver = $this->container->get( 'callableResolver' );
        
        return $resolver->resolve( $callable );
    }
}
