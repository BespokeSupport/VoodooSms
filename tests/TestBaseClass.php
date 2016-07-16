<?php

namespace BespokeSupport\VoodooSmsTest;

use BespokeSupport\VoodooSms\VoodooSmsClient;
use BespokeSupport\VoodooSms\VoodooSmsException;
use BespokeSupport\VoodooSms\VoodooSmsRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class TestBaseClass
 */
class TestBaseClass extends TestCase
{
    /**
     * @return VoodooSmsClient
     */
    protected function getClient()
    {
        $user = defined('VOODOO_API_USER') ? VOODOO_API_USER : 'user';
        $pass = defined('VOODOO_API_PASS') ? VOODOO_API_PASS : 'pass';

        $client = new VoodooSmsClient($user, $pass);

        return $client;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRequest()
    {
        $request = $this->getMockBuilder(VoodooSmsRequest::class)->getMock();

        return $request;
    }

    /**
     * @param \PHPUnit_Framework_MockObject_Stub $testResult
     * @return VoodooSmsClient
     */
    protected function getClientWithTestResponse(\PHPUnit_Framework_MockObject_Stub $testResult)
    {
        $client = $this->getClient();

        if (!defined('VOODOO_API_USER')) {
            $request = $this->getRequest();
            $request->method('getResponse')->will($testResult);
            $client->client = $request;
        }

        return $client;
    }

    /**
     * @param $exception
     * @return VoodooSmsClient
     */
    protected function getClientWithException(VoodooSmsException $exception = null)
    {
        $client = $this->getClient();

        if (!defined('VOODOO_API_USER')) {
            $request = $this->getRequest();
            $exception = ($exception) ? : new VoodooSmsException();
            $request->method('getResponse')->willThrowException($exception);
            $client->client = $request;
        }

        return $client;
    }
}
