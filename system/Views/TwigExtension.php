<?php

namespace System\Views;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var \System\Interfaces\RouterInterface
     */
    private $router;
    
    /**
     * @var string|\System\Http\Uri
     */
    private $uri;
    
    public function __construct ( $router, $uri )
    {
        $this->router = $router;
        $this->uri    = $uri;
    }
    
    public function getName ()
    {
        return 'System';
    }
    
    public function getFunctions ()
    {
        return [
            new \Twig_SimpleFunction( 'path_for', array ( $this, 'pathFor' ) ),
            new \Twig_SimpleFunction( 'base_url', array ( $this, 'baseUrl' ) ),
            new \Twig_SimpleFunction( 'is_current_path', array ( $this, 'isCurrentPath' ) ),
            new \Twig_SimpleFunction( 'current_path', array ( $this, 'currentPath' ) ),
        ];
    }
    
    public function pathFor ( $name, $data = [], $queryParams = [], $appName = 'default' )
    {
        return $this->router->pathFor( $name, $data, $queryParams );
    }
    
    public function baseUrl ()
    {
        if ( is_string( $this->uri ) ) {
            return $this->uri;
        }
        if ( method_exists( $this->uri, 'getBaseUrl' ) ) {
            return $this->uri->getBaseUrl();
        }
    }
    
    public function isCurrentPath ( $name, $data = [] )
    {
        return $this->router->pathFor( $name, $data ) === $this->uri->getBasePath() . '/' . ltrim( $this->uri->getPath(), '/' );
    }
    
    /**
     * Returns current path on given URI.
     *
     * @param bool $withQueryString
     *
     * @return string
     */
    public function currentPath ( $withQueryString = false )
    {
        if ( is_string( $this->uri ) ) {
            return $this->uri;
        }
        
        $path = $this->uri->getBasePath() . '/' . ltrim( $this->uri->getPath(), '/' );
        
        if ( $withQueryString && '' !== $query = $this->uri->getQuery() ) {
            $path .= '?' . $query;
        }
        
        return $path;
    }
    
    /**
     * Set the base url
     *
     * @param string|System\Http\Uri $baseUrl
     *
     * @return void
     */
    public function setBaseUrl ( $baseUrl )
    {
        $this->uri = $baseUrl;
    }
}
