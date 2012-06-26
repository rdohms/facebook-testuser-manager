<?php

namespace App\Action;

class NewAction extends Base
{
	
	public function run()
	{
        $permissions = false;
        if (defined('FACEBOOK_APP_DEFAULT_PERMISSIONS')) {
            $permissions = FACEBOOK_APP_DEFAULT_PERMISSIONS;
        }

		//Render Template
        $tpl = $this->getTplEngine()->loadTemplate('new.html');
        $tpl->display(array('permissions' => $permissions));
	}
	
}
