<?php

namespace App\Action;

class AjaxUserinfoBatchAction extends Base
{

	public function run()
	{

		try{

		    //Get list of users
            $fb = $this->getFacebookClient();

            //Get Input Params
            $package = $this->getInspekt()->post->getRaw('package');
            $tokens = array();
            $batch = array();

            foreach ($package as $p) {

                $tokens[ $p['id'] ] = $p['access_token'];

                $batch[] = '{ "method": "GET", "relative_url": "'.$p['id'].'?access_token='.$p['access_token'].'"}';
                $batch[] = '{ "method": "POST", "relative_url": "method/fql.query?query=select+'.$fb->getFacebookPermissionList().'+from+permissions+where+uid='.$p['id'].'"}';

            }

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

            $detailsArray = array();
            $tmp;
            if (!empty($batcheddata)) {

                foreach ($batcheddata as $result) {

                    $resultDecoded = \json_decode($result['body'], true);

                    //user data
                    if ( isset($resultDecoded['id']) ) {

                        $tmp = $resultDecoded;

                    }
                    //user perms
                    else {

                        $tmp['uid']             = $tmp['id'];
                        $tmp['access_token']    = $tokens[ $tmp['id'] ];

                        $allPerms = $resultDecoded[0];
                        //error_log(var_export($allPerms,true));
                        if (\is_array($allPerms) && count($allPerms) > 0) {
                            $perms = implode(', ',  \array_keys(\array_filter($allPerms)));
                            $tmp['perms'] = ($perms == '')? 'none defined':$perms;
                        } else {
                            $tmp['perms'] = 'none defined';
                        }

                        $detailsArray[] = $tmp;

                    }

                }

            } else {
                throw new \Exception($result);
            }

        } catch (\Exception $e) {
            error_log(var_export($e,true));
            $this->redirectToError($e, true);
            return;
        }

        $response = new \App\JsonResponse(200, null, $detailsArray);
        $response->sendOutput();
	}

}

?>