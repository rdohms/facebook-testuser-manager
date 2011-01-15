<?php
namespace App\Action;

class ErrorAction extends Base
{
	
	protected $error;
	
	public function run()
	{
		$error = new \stdClass();
		$error->message = $this->error->getMessage();
		var_dump($error);
        //Render Template
        $tpl = $this->getTplEngine()->loadTemplate('error.html');
        $tpl->display(array('error' => (array) $error));
	}
	
	public function setError($e)
	{
		$this->error = $e;
		
	}
}

?>