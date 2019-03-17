<?php
namespace System;
class BaseModule
{
	public $nameSpace;
	public $route;

	public function __construct()
	{
	}

	public function getRoute()
	{
		return $this->route;
	}
	public function getNameSpace()
	{
		return $this->nameSpace;
	}
}