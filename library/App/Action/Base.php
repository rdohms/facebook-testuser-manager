<?php

namespace App\Action;

abstract class Base implements iAction
{
	/**
	* @return \Facebook
	*/
	public function getFacebookClient()
	{
		return \Zend_Registry::get('facebook');
	}
	
	/**
	* @return App/Mustache/Mustache
	*/
	public function getMustache()
	{
		return \Zend_Registry::get('mustache');
	}
	
}

?>