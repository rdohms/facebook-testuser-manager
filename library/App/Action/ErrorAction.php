<?php
namespace App\Action;

class ErrorAction extends Base
{
	
	protected $error;
	
	public function run()
	{
		$error = new \stdClass();
		$error->message = $this->error->getMessage();
		
		$this->getMustache()->renderContent('error', array('error' => (array) $error));
	}
	
	public function setError($e)
	{
		$this->error = $e;
		
	}
}

?>