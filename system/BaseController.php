<?php

namespace System;

class BaseController
{
    protected $container;
    
    public function __construct ( $container )
    {
        $this->container = $container;
    }
    
    public function render ( $response, $view, $args )
    {
        $this->container->renderer->render( $response, $view . '.php', $args );
    }
}