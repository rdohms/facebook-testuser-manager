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
	* @return App/Template/Engine
	*/
	public function getTplEngine()
	{
		return \Zend_Registry::get('tplengine');
	}
	
	/**
	* @return \Inspekt
	*/
	public function getInspekt()
	{
		return \Zend_Registry::get('input');
	}

    public function redirectToError($e)
    {

        $error = new ErrorAction();
        $error->setError($e);
        $error->run();


    }
}

?>