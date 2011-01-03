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
            $perms = \array_filter(array_shift($allPerms));
            $details['perms'] = array();
            foreach($perms as $perm => $value){
                $details['perms'][] = array('name' => $perm);
            }

            //Add to user list with full data
            $users[] = \array_merge($user, $details);

        }

        //Render Template
		$this->getMustache()->renderContent('list', array('users' => $users));
	}
	
}

?>