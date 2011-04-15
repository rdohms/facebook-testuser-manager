<?php
namespace App\Facebook;

/**
 * Extends Facebook's PHP SDK
 *
 * This class allows us to execute custom processes that require test user
 * access tokens and not valid sessions to manage this resource.
 *
 */
class Client extends \Facebook
{

    /**
     * Allows override of Access Token to execute calls in name of test users
     * @var string
     */
    protected $accessToken;

    protected $permissionList = array();

    /**
     * Overrides Facebook's SDK call to pass it our defined Token and not
     * from a session.
     *
     * Returns regular SDK call if none set
     *
     * @return string
     */
    public function getAccessToken()
    {
        if ($this->accessToken !== null){
            return $this->accessToken;
        } else {
            return parent::getAccessToken();
        }

    }

    /**
     * Defines a Access Token Override, allowing us to use this access token
     * to make graph API calls, thus getting information for the test user
     *
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Cleans any Access Token Override, leaving regular calls in place
     */
    public function clearAccessToken()
    {
        $this->setAccessToken(null);
    }

    /**
     * Runs a FQL query agains the API
     *
     * @param string $query
     * @return array
     */
    public function fql($query)
    {
        $params = array(
            'method' => 'fql.query',
            'query' =>$query,
        );

        return $this->api($params);
    }

    /**
     *
     * @todo get this list from facebook they are able to filter valid/invalid
     * permissions no longer in the permisssions table
     * 
     * @return string
     */
    public function getFacebookPermissionList()
    {
        /**
        if ($this->permissionList == null){
            $list = $this->fql("SELECT permission_name FROM permissions_info WHERE 1=1");

            $this->permissionList = (\is_array($list))? implode(',', \array_map(function ($v) {return $v['permission_name'];}, $list)):'';
        }

        return $this->permissionList;
        */

        return 'read_stream,manage_friendlists,read_mailbox,publish_checkins,
            status_update,photo_upload,video_upload,create_event,rsvp_event,
            offline_access,email,xmpp_login,create_note,share_item,
            export_stream,publish_stream,ads_management,read_insights,
            read_requests,read_friendlists,manage_pages,
            user_birthday,friends_birthday,user_religion_politics,
            friends_religion_politics,user_relationships,friends_relationships,
            user_relationship_details,friends_relationship_details,
            user_hometown,friends_hometown,user_location,friends_location,
            user_likes,friends_likes,user_activities,friends_activities,
            user_interests,friends_interests,user_education_history,
            friends_education_history,user_work_history,friends_work_history,
            user_online_presence,friends_online_presence,user_website,
            friends_website,user_groups,friends_groups,user_events,
            friends_events,user_photos,friends_photos,user_videos,
            friends_videos,user_photo_video_tags,friends_photo_video_tags,
            user_notes,friends_notes,user_checkins,friends_checkins,
            user_about_me,friends_about_me,user_status,friends_status';
    }
}
?>
