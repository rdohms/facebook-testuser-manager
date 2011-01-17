<?php
namespace App\Action;

class ErrorAction extends Base
{
	
	protected $error;
	
	public function run()
	{
        //Render Template
        $tpl = $this->getTplEngine()->loadTemplate('error.html');
        $tpl->display(array('error' => $this->error));
	}
	
	public function setError($e)
	{
		$this->error = $e;
		
	}
}

?>