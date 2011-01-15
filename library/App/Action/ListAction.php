<?php

namespace App\Action;

class ListAction extends Base
{
	
	public function run()
	{
		//Get list of users
        $fb = $this->getFacebookClient();
        $response = $fb->api('/'.$fb->getAppId().'/accounts/test-users');
        $testUsers = (\array_key_exists('data', $response))? $response['data']:array();

		//Get extra data
        $users = array();
        foreach($testUsers as $user){
            $fb->setAccessToken($user['access_token']);
            $details = $fb->api('/me');

            //Get Available perms
            $allPerms = $fb->fql('SELECT '.$fb->getFacebookPermissionList().' FROM permissions WHERE uid = "'.$user['id'].'"');
            $user['perms'] = \array_filter(array_shift($allPerms));


            //Add to user list with full data
            $users[] = \array_merge($user, $details);

        }

        //Render Template
        $tpl = $this->getTplEngine()->loadTemplate('list.html');
        $tpl->display(array('users' => $users));
	}
	
}

?>