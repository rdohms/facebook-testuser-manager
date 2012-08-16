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

            $batch = array();

            $batch[] = '{ "method": "POST", "relative_url": "/'.$uid_user.'/friends/'.$uid_friend.'?access_token='.$token_user.'"}';
            $batch[] = '{ "method": "POST", "relative_url": "/'.$uid_friend.'/friends/'.$uid_user.'?access_token='.$token_friend.'"}';

            $batched_request = '['.\implode(',', $batch).']';

            //set POST variables
            $url = "https://graph.facebook.com/?batch="
                . \urlencode(\trim($batched_request))
                . "&access_token=".$fb->getAppId().'|'.$fb->getApiSecret()."&method=post";

            $ch = \curl_init();
            \curl_setopt($ch, CURLOPT_URL, $url);
            \curl_setopt($ch, CURLOPT_POST, 1);
            \curl_setopt($ch, CURLOPT_POSTFIELDS, $batched_request);
            \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = \curl_exec($ch);
            \curl_close($ch);

            $batcheddata = \json_decode($result, true);
            if (!empty($batcheddata)) {

                foreach ($batcheddata as $result) {
                    $resultDecoded = \json_decode($result['body'], true);
                }

            } else {
                throw new \Exception($result);
            }

        } catch(\Exception $e) {
            $this->redirectToError($e, true);
            return;
        }

        $response = new \App\JsonResponse(200, "Relationship established succesfully");
        $response->sendOutput();
	}

}

?>