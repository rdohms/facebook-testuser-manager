<?php

namespace App\Action;

class NewAction extends Base
{

	public function run()
	{
		//Render Template
        $tpl = $this->getTplEngine()->loadTemplate('new.html');
        $tpl->display(array('parent' => 'layout.html'));
	}

}

?>