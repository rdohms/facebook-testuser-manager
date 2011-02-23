<?php

namespace App\Action;

class AjaxUserinfoAction extends Base
{

	public function run()
	{

		try{
            
            //Get list of users
            $fb = $this->getFacebookClient();

            //Get Input Params
            $uid = $this->getInspekt()->post->getAlnum('uid');
            $token = $this->getInspekt()->post->getRaw('token');

            //Get extra data
            $fb->setAccessToken($token);
            $details = $fb->api('/me');

            //Get Available perms
            $allPerms = $fb->fql('SELECT '.$fb->getFacebookPermissionList().' FROM permissions WHERE uid = "'.$uid.'"');

            if (\is_array($allPerms) && count($allPerms) > 0){
                $perms = implode(', ',  \array_keys(\array_filter(array_shift($allPerms))));
                $details['perms'] = ($perms == '')? 'none defined':$perms;
            } else {
                $details['perms'] = 'none defined';
            }
            
            $details['uid'] = $uid;
            $details['access_token'] = $token;

        } catch (\Exception $e) {
            $this->redirectToError($e, true);
            return;
        }

        $response = new \App\JsonResponse(200, null, $details);
        $response->sendOutput();
	}

}

?>