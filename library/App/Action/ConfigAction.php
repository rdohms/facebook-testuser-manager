<?php

namespace App\Action;

class ConfigAction extends Base
{
	
	public function run()
	{
		//Render Template
		$tpl = $this->getTplEngine()->loadTemplate('config.html');
        $tpl->display(array());
	}
	
}

?>