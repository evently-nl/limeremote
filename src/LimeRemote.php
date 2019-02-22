<?php

namespace evently\LimeRemote;

use evently\LimeRemote\Traits\LimesurveyRemoteHelperTrait;
use evently\LimeRemote\Traits\LimesurveyRemoteTrait;
use Exception;
use Graze\GuzzleHttp\JsonRpc\Client;

class LimeRemote
{
    use LimesurveyRemoteTrait;
    use LimesurveyRemoteHelperTrait;
    protected $username, $password, $url, $limesurveyId, $debug, $client, $sessionKey;

    /**
     * LimeRemote constructor.
     * @param $username
     * @param $password
     * @param $url
     * @param null $limesurveyId
     * @param bool $debug
     */
    public function __construct($username, $password, $url, $limesurveyId=null, $debug=false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->limesurveyId = $limesurveyId;
        $this->debug = $debug;
        $this->client = Client::factory($this->url);
        $this->sessionKey = $this->getSessionKey();
    }


    public function testRequest($type, array $variables)
    {
            array_unshift($variables, $this->sessionKey);
            return $variables;
    }












    protected function createDefaultRequest($type, array $variables)
    {
        array_unshift($variables, $this->sessionKey);
        return $this->client->request(1, $type, $variables);
    }

    protected function isLimesurveyIdSet()
    {
        return (!isset($this->limesurveyId)) ? false : true;
    }

}