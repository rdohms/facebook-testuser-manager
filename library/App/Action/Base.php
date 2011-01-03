<?php

namespace App\Action;

abstract class Base implements iAction
{
	/**
	* @return \App\Facebook\Client
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
	
	/**
	* @return \Inspekt
	*/
	public function getInspekt()
	{
		return \Zend_Registry::get('input');
	}
}

?>