<?php

namespace System;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Pimple\Container as PimpleContainer;
use System\Exception\ContainerException as SystemContainerException;
use System\Exception\ContainerValueNotFoundException;

/**
 * System's default DI container is Pimple.
 *
 * System\App expects a container that implements Psr\Container\ContainerInterface
 * with these service keys configured and ready for use:
 *
 *  - settings: an array or instance of \ArrayAccess
 *  - environment: an instance of \System\Interfaces\Http\EnvironmentInterface
 *  - request: an instance of \Psr\Http\Message\ServerRequestInterface
 *  - response: an instance of \Psr\Http\Message\ResponseInterface
 *  - router: an instance of \System\Interfaces\RouterInterface
 *  - foundHandler: an instance of \System\Interfaces\InvocationStrategyInterface
 *  - errorHandler: a callable with the signature: function($request, $response, $exception)
 *  - notFoundHandler: a callable with the signature: function($request, $response)
 *  - notAllowedHandler: a callable with the signature: function($request, $response, $allowedHttpMethods)
 *  - callableResolver: an instance of \System\Interfaces\CallableResolverInterface
 *
 * @property-read array                                          $settings
 * @property-read \System\Interfaces\Http\EnvironmentInterface   $environment
 * @property-read \Psr\Http\Message\ServerRequestInterface       $request
 * @property-read \Psr\Http\Message\ResponseInterface            $response
 * @property-read \System\Interfaces\RouterInterface             $router
 * @property-read \System\Interfaces\InvocationStrategyInterface $foundHandler
 * @property-read callable                                       $errorHandler
 * @property-read callable                                       $notFoundHandler
 * @property-read callable                                       $notAllowedHandler
 * @property-read \System\Interfaces\CallableResolverInterface   $callableResolver
 */
class Container extends PimpleContainer implements ContainerInterface
{
    /**
     * Default settings
     *
     * @var array
     */
    private $defaultSettings
        = [
            'httpVersion'                       => '1.1',
            'responseChunkSize'                 => 4096,
            'outputBuffering'                   => 'append',
            'determineRouteBeforeAppMiddleware' => false,
            'displayErrorDetails'               => false,
            'addContentLengthHeader'            => true,
            'routerCacheFile'                   => false,
        ];
    
    /**
     * Create new container
     *
     * @param array $values The parameters or objects.
     */
    public function __construct ( array $values = [] )
    {
        parent::__construct( $values );
        
        $userSettings = isset( $values[ 'settings' ] ) ? $values[ 'settings' ] : [];
        $this->registerDefaultServices( $userSettings );
    }
    
    /**
     * This function registers the default services that System needs to work.
     *
     * All services are shared - that is, they are registered such that the
     * same instance is returned on subsequent calls.
     *
     * @param array $userSettings Associative array of application settings
     *
     * @return void
     */
    private function registerDefaultServices ( $userSettings )
    {
        $defaultSettings = $this->defaultSettings;
        
        /**
         * This service MUST return an array or an
         * instance of \ArrayAccess.
         *
         * @return array|\ArrayAccess
         */
        $this[ 'settings' ] = function () use ( $userSettings, $defaultSettings ) {
            return new Collection( array_merge( $defaultSettings, $userSettings ) );
        };
        
        $defaultProvider = new DefaultServicesProvider();
        $defaultProvider->register( $this );
    }
    
    /********************************************************************************
     * Methods to satisfy Psr\Container\ContainerInterface
     *******************************************************************************/
    
    /********************************************************************************
     * Magic methods for convenience
     *******************************************************************************/
    
    public function __get ( $name )
    {
        return $this->get( $name );
    }
    
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws ContainerValueNotFoundException  No entry was found for this identifier.
     * @throws ContainerException               Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get ( $id )
    {
        if ( !$this->offsetExists( $id ) ) {
            throw new ContainerValueNotFoundException( sprintf( 'Identifier "%s" is not defined.', $id ) );
        }
        try {
            return $this->offsetGet( $id );
        }
        catch ( \InvalidArgumentException $exception ) {
            if ( $this->exceptionThrownByContainer( $exception ) ) {
                throw new SystemContainerException(
                    sprintf( 'Container error while retrieving "%s"', $id ),
                    null,
                    $exception
                );
            } else {
                throw $exception;
            }
        }
    }
    
    /**
     * Tests whether an exception needs to be recast for compliance with Container-Interop.  This will be if the
     * exception was thrown by Pimple.
     *
     * @param \InvalidArgumentException $exception
     *
     * @return bool
     */
    private function exceptionThrownByContainer ( \InvalidArgumentException $exception )
    {
        $trace = $exception->getTrace()[ 0 ];
        
        return $trace[ 'class' ] === PimpleContainer::class && $trace[ 'function' ] === 'offsetGet';
    }
    
    public function __isset ( $name )
    {
        return $this->has( $name );
    }
    
    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has ( $id )
    {
        return $this->offsetExists( $id );
    }
}
