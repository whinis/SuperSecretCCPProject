<?php

/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 6:10 PM
 */
include_once("class_Curl.php");
class crest
{
    private $unauthedEndpoint = "https://public-crest.eveonline.com";
    private $authedEnpoint = "https://crest-tq.eveonline.com";
    private $endpoint = "";


    private $clientID;
    private $secret;
    private $redirectURL;
    private $debug;
    private $curl;

    private $accessToken;
    private $refreshToken;
    private $expires;
    private $tokenType;
    private static $_instance;

    /**
     * class_crest constructor.
     * @param null $curl, a preinitialized curl class
     */
    public function __construct($curl = null){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }

        if(isset($_SESSION['CREST'])){ //check if we have an active crest session
            if(isset($_SESSION['CREST']['access'])) {   //we have an access token, update fields
                $this->accessToken = $_SESSION['CREST']['access'];
                $this->tokenType = $_SESSION['CREST']['type'];
                $this->expires = $_SESSION['CREST']['expires'];
            }

            if(isset($_SESSION['CREST']['refreshToken']))   //we have a refresh token, we might need this
                $this->refreshToken = $_SESSION['CREST']['refresh'];
            $this->endpoint = $this->authedEnpoint;
        }else{
            $this->endpoint = $this->unauthedEndpoint;
        }


        if($curl != null){
            $this->curl = $curl;
        }else{
            $this->curl = new Curl();
        }
    }

    public static function instance(){

        if(null === self::$_instance) {
            self::$_instance = new crest();
        }
        return self::$_instance;
    }

    /**
     * function to set needed values to use crest
     * @param $clientID
     * @param $secret
     * @param $redirectURL
     */
    public function initialize($clientID,$secret,$redirectURL)
    {
        $this->clientID = $clientID;
        $this->secret = $secret;
        $this->redirectURL = $redirectURL;
    }

    private function get($url)
    {
        $result = $this->curl->get($url);
        return json_decode($result,true);
    }

    public static function getKill($killID,$hash)
    {
        $instance = crest::instance();
        $result = $instance->get($instance->endpoint."/killmails/$killID/$hash/");
        return $result;
    }


    public static function getType($typeID)
    {
        $instance = crest::instance();
        $result = $instance->get($instance->endpoint."/types/$typeID/");
        return $result;
    }

    public static function getGraphic($graphicID)
    {
        $instance = crest::instance();
        if(is_array($graphicID))
            $result = $instance->get($graphicID['href']);
        else
            $result = $instance->get($instance->endpoint."/graphicids/$graphicID/");
        return $result;
    }

}