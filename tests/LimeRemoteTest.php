<?php

namespace evently\LimeRemote\Tests;

use PHPUnit\Framework\TestCase;
use evently\LimeRemote\LimeRemote;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;


class LimeRemoteTest extends TestCase
{
    /** @test */
    public function it_returns_a_remote()
    {
              
        $remote = new LimeRemote('admin','password','http://limesurvey.test/admin/remotecontrol',null,false);
        $this->assertNotEmpty($remote->getSessionKey());
        
    }

    /** @test */
    public function it_can_send_a_generic_request()
    {
              
        $remote = new LimeRemote('admin','password','http://limesurvey.test/admin/remotecontrol',null,false);
        $request = $remote->testRequest('test',['variables']);
        dump($request);
        $this->assertNotEmpty($request);
        
    }


}