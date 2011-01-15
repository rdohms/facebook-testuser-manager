<?php

namespace App\Action;

class CreateAction extends Base
{
	
	public function run()
	{	
		$fb = $this->getFacebookClient();

        $params = array();
        $params['installed'] = $this->getInspekt()->post->getInt('installed');
        $params['permissions'] = $this->getInspekt()->post->getRaw('permissions');
        var_dump($fb->getAppId());
        $user = $fb->api('/'.$fb->getAppId().'/accounts/test-users', 'POST', $params);

        var_dump($user);

	}
	
}

?>