<?php

namespace App\Action;

class AjaxAppNameAction extends Base
{

    public function run()
    {

        try{

            $fb = $this->getFacebookClient();
            $appdata = $fb->api('/'.$fb->getAppId().'?access_token='.$fb->getAccessToken());

        } catch (\Exception $e) {
            $this->redirectToError($e, true);
            return;
        }

        $response = new \App\JsonResponse(200, null, $appdata);
        $response->sendOutput();
    }

}

?>