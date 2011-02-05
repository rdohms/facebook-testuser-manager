<?php

namespace App\Action;

class ListAction extends Base
{
	
	public function run()
	{
        if (!$this->checkTokens()){
            return;
        }

		try{
            //Get list of users
            $fb = $this->getFacebookClient();
            $fb->setAccessToken(null);
            $response = $fb->api('/'.$fb->getAppId().'/accounts/test-users');
            $testUsers = (\array_key_exists('data', $response))? $response['data']:array();

        } catch (\Exception $e) {
            $this->redirectToError($e);
            return;
        }

        //Render Template
        $tpl = $this->getTplEngine()->loadTemplate('list.html');
        $tpl->display(array('users' => $testUsers));
	}
	
}

?>