<?php

namespace App;

/**
 * Handles Application Routing and request processing
 *
 * @category FBTUM
 * @package App
 */
class Application
{

    /**
     * Constructor
     * Instantiates all neede libraries and makes them available
     */
	public function __construct()
	{

        $this->loadSessionTokens();

		//Wrap all input in Inspekt
		$input = \Inspekt::makeSuperCage();
        \Zend_Registry::set('input', $input);

		//Get a Mustache Factory up
		$tplEngine = new Template\Engine();
        \Zend_Registry::set('tplengine', $tplEngine);

		//Singleton our facebook interface
        if (\defined('FACEBOOK_APP_ID') && \defined('FACEBOOK_APP_SECRET')){

            $facebook = new Facebook\Client(array(
              'appId'  => FACEBOOK_APP_ID,
              'secret' => FACEBOOK_APP_SECRET
            ));

            \Zend_Registry::set('facebook', $facebook);

            $tplEngine->addGlobal('FB_APP_ID', FACEBOOK_APP_ID);

        }


	}

    /**
     * Runs the request.
     * Finds the requested action and executes it
     */
	public function run()
	{
		try {
			$httpHost = \Zend_Registry::get('input')->server->getRaw('HTTP_HOST');
			$requestUri = \Zend_Registry::get('input')->server->getRaw('REQUEST_URI');

            $publicPos = strrpos($requestUri, 'public');
            $substrLen = ($publicPos !== false)? $publicPos+6 : $publicPos;
            $path = substr($requestUri, 0, $substrLen );

            \define('BASE_URL', 'http://'.$httpHost.$path.'/' );

			$action = $this->getActionClass($requestUri);
			$action->run();

		} catch (\Exception $e) {
			$action = new Action\ErrorAction();
			$action->setError($e);
			$action->run();
		}
	}

    /**
     * Extracts the Action Name from a request uri
     *
     * @param string $name
     * @return \App\Action\iAction
     */
	private function getActionClass($name)
	{
		//Strip rest of url if not in its own VirtualHost
		$name = substr($name, strrpos($name, 'public') );
		$name = str_replace('public/', '', $name);
		$name = ($name == "" || null === $name || $name == "/")? 'list':$name;

        if (\substr($name, 0, 1) == '/'){
            $name = \substr($name, 1);
        }

        if (strpos($name, '/') != false) {
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

    /**
     * Loads Tokens if they are set in the session
     */
    private function loadSessionTokens()
    {
        if (\defined('USE_SESSION') && \USE_SESSION){
            if (!\defined('FACEBOOK_APP_ID') && isset($_SESSION['FACEBOOK_APP_ID'])){
                \define('FACEBOOK_APP_ID', $_SESSION['FACEBOOK_APP_ID']);
            }

            if (!\defined('FACEBOOK_APP_SECRET') && isset($_SESSION['FACEBOOK_APP_SECRET'])){
                \define('FACEBOOK_APP_SECRET', $_SESSION['FACEBOOK_APP_SECRET']);
            }
        }
    }
}

?>