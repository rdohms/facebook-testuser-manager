<?php
namespace App\Action;

class ErrorAction extends Base
{
	
	protected $error;
	
	public function run()
	{
        header("HTTP/1.0 500 Internal Error");

        if ($this->getIsAjax()) {
            $response = new \App\JsonResponse($this->error->getCode(), $this->error->getMessage());
            $response->sendOutput();
        } else {
            //Render Template
            $tpl = $this->getTplEngine()->loadTemplate('error.html');
            $tpl->display(array('error' => $this->error));
        }
	}
	
	public function setError($e)
	{
		$this->error = $e;
		
	}
}

?>