<?php

namespace App\Action;

class AjaxChangeNameAction extends Base
{

	public function run()
	{

        try {

            $fb = $this->getFacebookClient();
            $uid = $this->getInspekt()->post->getRaw('uid');

            $params = array();
            $params['name'] = $this->getInspekt()->post->getRaw('name');

            $changeName = $fb->api('/'.$uid, 'POST', $params);

        } catch (\Exception $e) {

            $this->redirectToError('Facebook exception: '.$e);
            return;

        }

        $response = new \App\JsonResponse(200, null, null);
        $response->sendOutput();

	}

}

