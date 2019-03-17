<?php

namespace Modules\Home\Controllers;

use System\Http\Request;
use System\Http\Response;

class HomeController extends \System\BaseController
{
    public function index ( Request $request, Response $response )
    {
        return $this->render( $response, 'index', [ 'name' => 'World' ] );
    }
    public function about ( Request $request, Response $response )
    {
        return $this->render( $response, 'index', [ 'name' => 'World' ] );
    }
}
