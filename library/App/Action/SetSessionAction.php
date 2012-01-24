<?php

namespace App\Action;

class SetSessionAction extends Base
{
	
	public function run()
	{
        //Check submitted
        $appId          = $this->getInspekt()->post->getAlnum('fb_app_id');
        $appSecret      = $this->getInspekt()->post->getAlnum('fb_app_secret');
        $appPermissions = $this->getInspekt()->post->getAlnum('fb_app_permissions');

        
        if ($appId) $_SESSION['FACEBOOK_APP_ID'] = $appId;
        if ($appSecret) $_SESSION['FACEBOOK_APP_SECRET'] = $appSecret;
        if ($appPermissions) $_SESSION['FACEBOOK_APP_DEFAULT_PERMISSIONS'] = $appPermissions;

        //Check for clear session
        $submitAction = $this->getInspekt()->post->getAlnum('action');
        if($submitAction == "ClearcurrentAppID"){
            unset($_SESSION['FACEBOOK_APP_ID']);
            unset($_SESSION['FACEBOOK_APP_SECRET']);
            unset($_SESSION['FACEBOOK_APP_DEFAULT_PERMISSIONS']);
        }
        
        //Check Session
        $sessionAppId = (isset($_SESSION['FACEBOOK_APP_ID']))? $_SESSION['FACEBOOK_APP_ID']:null;

        //Check no session
        if (\defined('USE_SESSION') && USE_SESSION){
            $noSession = false;
        } else {
            $noSession = true;
        }

        //Render Template
		$tpl = $this->getTplEngine()->loadTemplate('set_session.html');
        $tpl->display(array(
            'appId' => $appId, 
            'appSecret' => $appSecret,
            'appPermissions' => $appPermissions,
            'sessionAppId' => $sessionAppId,
            'noSession' => $noSession
        ));
        
	}
	
}
