<?php

namespace App\Action;

class ListAction extends Base
{
	
	public function run()
	{
		try{
            //Get list of users
            $fb = $this->getFacebookClient();
            $fb->setAccessToken(null);
            $response = $fb->api('/'.$fb->getAppId().'/accounts/test-users');
            $testUsers = (\array_key_exists('data', $response))? $response['data']:array();
$users = $testUsers;
//            //Get extra data
//            $users = array();
//            foreach($testUsers as $user){
//                $fb->setAccessToken($user['access_token']);
//                //$details = $fb->api('/me');
//
//                //Get Available perms
//                //$allPerms = $fb->fql('SELECT '.$fb->getFacebookPermissionList().' FROM permissions WHERE uid = "'.$user['id'].'"');
//                //$user['perms'] = \array_filter(array_shift($allPerms));
//
//
//                //Add to user list with full data
//                //$users[] = \array_merge($user, $details);
//
//            }
        } catch (\Exception $e) {
            $this->redirectToError($e);
            return;
        }

        //Render Template
        $tpl = $this->getTplEngine()->loadTemplate('list.html');
        $tpl->display(array('users' => $users));
	}
	
}

?>