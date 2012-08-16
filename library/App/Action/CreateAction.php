<?php

namespace App\Action;

class CreateAction extends Base
{

	public function run()
	{
        try {

            $fb = $this->getFacebookClient();

            $params = array();
            $params['name'] = $this->getInspekt()->post->getRaw('name');
            $params['installed'] = $this->getInspekt()->post->getInt('installed');
            $params['permissions'] = $this->getInspekt()->post->getRaw('permissions');

            if (empty($params['name'])) {
                unset($params['name']);
            }

            $user = $fb->api('/'.$fb->getAppId().'/accounts/test-users', 'POST', $params);

            if (is_array($user)){

                $fb->setAccessToken($user['access_token']);
                $details = $fb->api('/me');

                $user = \array_merge($user,$details);
                $success = true;

            }

        } catch (\Exception $e) {
            $this->redirectToError($e);
            return;
        }

        $tpl = $this->getTplEngine()->loadTemplate('create.html');
        $tpl->display(array('error' => !isset($success), 'user' => $user));

	}

}

?>