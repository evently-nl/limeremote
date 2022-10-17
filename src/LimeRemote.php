<?php

namespace Evently\LimeRemote;

use Evently\LimeRemote\jsonRPCClient;
use Evently\LimeRemote\Traits\LimesurveyRemoteCheckTrait;
use Evently\LimeRemote\Traits\LimesurveyRemoteHelperTrait;
use Evently\LimeRemote\Traits\LimesurveyRemoteTrait;
use Exception;

class LimeRemote
{
    use LimesurveyRemoteTrait;
    use LimesurveyRemoteHelperTrait;
    use LimesurveyRemoteCheckTrait;

    protected $username;
    protected $password;
    protected $url;
    protected $limesurveyId;
    protected $debug;
    protected $client;
    protected $sessionKey;

    /**
     * LimeRemote constructor.
     * @param $username
     * @param $password
     * @param $url
     * @param null $limesurveyId
     * @param bool $debug
     */
    public function __construct($username, $password, $url, $limesurveyId = null, $debug = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->limesurveyId = $limesurveyId;
        $this->debug = $debug;
        $this->client = new jsonRPCClient($this->url, $this->debug);
        $this->sessionKey = $this->getSessionKey();
    }

    public function setLimesurveyId($sid)
    {
        $this->limesurveyId = $sid;
    }
}
