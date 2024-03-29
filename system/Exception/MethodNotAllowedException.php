<?php

namespace System\Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MethodNotAllowedException extends SystemException
{
    /**
     * HTTP methods allowed
     *
     * @var string[]
     */
    protected $allowedMethods;
    
    /**
     * Create new exception
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param string[]               $allowedMethods
     */
    public function __construct ( ServerRequestInterface $request, ResponseInterface $response, array $allowedMethods )
    {
        parent::__construct( $request, $response );
        $this->allowedMethods = $allowedMethods;
    }
    
    /**
     * Get allowed methods
     *
     * @return string[]
     */
    public function getAllowedMethods ()
    {
        return $this->allowedMethods;
    }
}
