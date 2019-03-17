<?php

namespace System\Interfaces;

/**
 * Resolves a callable.
 *
 * @package System
 * @since   3.0.0
 */
interface CallableResolverInterface
{
    /**
     * Invoke the resolved callable.
     *
     * @param mixed $toResolve
     *
     * @return callable
     */
    public function resolve ( $toResolve );
}
