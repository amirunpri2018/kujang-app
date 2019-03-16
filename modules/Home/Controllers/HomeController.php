<?php
namespace Modules\Home\Controllers;

use System\Http\Request;
use System\Http\Response;
class HomeController extends \System\BaseController
{
	public function home(Request $request, Response $response){
		return $this->render($response, 'index',['name'=>'World']);
	}
}
