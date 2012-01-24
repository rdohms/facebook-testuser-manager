<?php

namespace App\Action;

class CreateAction extends Base
{
	
	public function run()
	{
        try {
            $fb = $this->getFacebookClient();

            $params = array();
            $params['installed'] = $this->getInspekt()->post->getInt('installed');
            $params['permissions'] = $this->getInspekt()->post->getRaw('permissions');

            $user = $fb->api('/'.$fb->getAppId().'/accounts/test-users', 'POST', $params);

            // check if the user has been created successfully
            if (is_array($user)) {
                $success = true;
            }

            // get more informations about the user
            // case if they already installed on your app
            if ($params['installed']) {
                $fb->setAccessToken($user['access_token']);
                $details = $fb->api('/me');

                $user = \array_merge($user,$details);
            }
        } catch (\Exception $e) {
            $this->redirectToError($e);
            return;
        }

        $tpl = $this->getTplEngine()->loadTemplate('create.html');
        $tpl->display(array('error' => !isset($success), 'user' => $user));

	}
	
}
