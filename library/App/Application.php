<?php

namespace App;

class Application
{
		
	public function __construct()
	{
		//Wrap all input in Inspekt
		$input = \Inspekt::makeSuperCage();  
		
		//Get a Mustache Factory up
		$mustache = new \App\Mustache\Mustache();
		
		//Singleton our facebook interface
		$facebook = new \Facebook(array(
		  'appId'  => FACEBOOK_APP_ID,
		  'secret' => FACEBOOK_APP_SECRET
		));
		
		//Store all in registry for later use
		\Zend_Registry::set('mustache', $mustache);
		\Zend_Registry::set('facebook', $facebook);
		\Zend_Registry::set('input', $input);
		
	}
	
	public function run()
	{
		try {
			$actionName = \Zend_Registry::get('input')->server->getRaw('REQUEST_URI');

			$action = $this->getActionClass($actionName);
			$action->run();
			
		} catch (\Exception $e) {
			$action = new Action\ErrorAction();
			$action->setError($e);
			$action->run();
		}
	}
	
	private function getActionClass($name)
	{
		//Strip rest of url if not in its own VirtualHost
		$name = substr($name, strrpos($name, 'public') );
		$name = str_replace('public/', '', $name);
		$name = ($name == "" || null === $name || $name == "/")? 'list':$name;

		if (strpos($name, '/') !== false) {
			$name = strstr($name, '/', true);
		}

		$name = str_replace('-', ' ', $name);
		$name = ucwords($name);
		$name = str_replace(' ', '', $name);
		
		$class = 'App\\Action\\' . $name . 'Action';
		if (!class_exists($class)){
			$action = new \App\Action\ErrorAction();
			$action->setError( new \Exception('Action '.$name.' not defined') );

			return $action;
		}
		
		return new $class;
		
	}
}

?>