<?php

namespace App\Action;

class AjaxAddFriendAction extends Base
{

	public function run()
	{

        $fb = $this->getFacebookClient();

        try{
            //Get Ids and tokens
            $uid_user = $this->getInspekt()->post->getAlnum('origin_user');
            $token_user = $this->getInspekt()->post->getRaw('origin_user_token');

            //Break down target info
            $data_friend = $this->getInspekt()->post->getRaw('target_user');
            $data_friend = \explode(" ", $data_friend);
            $uid_friend = $data_friend[0];
            $token_friend = $data_friend[1];

            //Request 1 in name or origin user
            $fb->setAccessToken($token_user);
            $resA = $fb->api('/'.$uid_user.'/friends/'.$uid_friend, "POST");

            //Request 2 in name or target user
            $fb->setAccessToken($token_friend);
            $resB = $fb->api('/'.$uid_friend.'/friends/'.$uid_user, "POST");

        } catch(\Exception $e) {
            $this->redirectToError($e, true);
            return;
        }

        $response = new \App\JsonResponse(200, "Relationship established succesfully");
        $response->sendOutput();
	}

}

?>