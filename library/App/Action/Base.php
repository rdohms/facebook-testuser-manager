<?php

namespace App\Action;

abstract class Base implements iAction
{
    protected $isAjax = false;

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

    public function redirectToError($e, $isAjax = false)
    {

        $error = new ErrorAction();
        $error->setIsAjax($isAjax);
        $error->setError($e);
        $error->run();

    }

    public function getIsAjax()
    {
        return $this->isAjax;
    }

    public function setIsAjax($isAjax)
    {
        $this->isAjax = $isAjax;
    }

    protected function checkTokens()
    {
        if (!\defined('FACEBOOK_APP_ID') || !\defined('FACEBOOK_APP_SECRET')){
            $e = new \Exception('App ID and Secret not set, please rename <strong>config.ini.php.sample</strong> to <strong>config.ini.php</strong> and set the App ID and Secret', 400);
            $this->redirectToError($e);
            return false;
        }

        return true;
    }

}

?>