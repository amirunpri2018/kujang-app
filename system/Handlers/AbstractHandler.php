<?php

namespace System\Handlers;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Abstract System application handler
 */
abstract class AbstractHandler
{
    /**
     * Known handled content types
     *
     * @var array
     */
    protected $knownContentTypes
        = [
            'application/json',
            'application/xml',
            'text/xml',
            'text/html',
        ];
    
    /**
     * Determine which content type we know about is wanted using Accept header
     *
     * Note: This method is a bare-bones implementation designed specifically for
     * System's error handling requirements. Consider a fully-feature solution such
     * as willdurand/negotiation for any other situation.
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function determineContentType ( ServerRequestInterface $request )
    {
        $acceptHeader         = $request->getHeaderLine( 'Accept' );
        $selectedContentTypes = array_intersect( explode( ',', $acceptHeader ), $this->knownContentTypes );
        
        if ( count( $selectedContentTypes ) ) {
            return current( $selectedContentTypes );
        }
        
        // handle +json and +xml specially
        if ( preg_match( '/\+(json|xml)/', $acceptHeader, $matches ) ) {
            $mediaType = 'application/' . $matches[ 1 ];
            if ( in_array( $mediaType, $this->knownContentTypes ) ) {
                return $mediaType;
            }
        }
        
        return 'text/html';
    }
}
