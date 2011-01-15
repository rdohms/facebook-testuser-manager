<?php

namespace App\Action;

class AboutAction extends Base
{
	
	public function run()
	{
		//Render Template
		$tpl = $this->getTplEngine()->loadTemplate('about.html');
        $tpl->display(array());
	}
	
}

?>