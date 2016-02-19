<?php

/**
 * Created by PhpStorm.
 * User: John
 * Date: 2/18/2016
 * Time: 6:10 PM
 */
include_once("class_Curl.php");
class class_crest
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
            $this->endpoint = $this->unauthedEnpoint;
        }


        if($curl != null){
            $this->curl = $curl;
        }else{
            $this->curl = new Curl();
        }
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

    public function getKill($killID,$hash)
    {
        $result = $this->curl->get($this->endpoint."/killmails/$killID/$hash/");
    }

}