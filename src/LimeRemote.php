<?php

namespace Evently\LimeRemote;

use Evently\LimeRemote\Traits\LimesurveyRemoteHelperTrait;
use Evently\LimeRemote\Traits\LimesurveyRemoteTrait;
use Evently\LimeRemote\Traits\LimesurveyRemoteCheckTrait;

use Exception;
use Graze\GuzzleHttp\JsonRpc\Client;

class LimeRemote
{
    use LimesurveyRemoteTrait;
    use LimesurveyRemoteHelperTrait;
    use LimesurveyRemoteCheckTrait;

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

    public function setLimesurveyId ($sid)
    {
        $this->limesurveyId = $sid;
    }

}