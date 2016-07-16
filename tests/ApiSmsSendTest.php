<?php

use BespokeSupport\VoodooSms\VoodooSmsExceptionClient;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

/**
 * Class ApiSmsSendTest
 */
class ApiSmsSendTest extends TestBaseClass
{
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testFail()
    {
        $client = $this->getClient();
        $client->sendSms();
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsExceptionClient
     */
    public function testFailNumber()
    {
        $responseObject = new stdClass();
        $responseObject->result = 400;
        $responseObject->resultTest = 'BAD REQUEST Originator';

        $from = '449999999999';
        $to = '449999999999';
        $message = 'TEST MESSAGE';

        $client = $this->getClientWithException(new VoodooSmsExceptionClient());

        $client->sendSms($from, $to, $message);
    }

    /**
     *
     */
    public function testOk()
    {
        $responseObject = new stdClass();
        $responseObject->result = 200;
        $responseObject->resultText = '200 OK';
        $responseObject->reference_id = array(
            '999QQ9QQQ9Q9999999999'
        );

        $from = '447860041446';
        $to = '447999999999';
        $message = 'TEST MESSAGE';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->sendSms($from, $to, $message);

        $this->assertSame($responseObject->reference_id[0], $response);
    }

    /**
     *
     */
    public function testMultipleOk()
    {
        $responseObject = new stdClass();
        $responseObject->result = 200;
        $responseObject->resultText = '200 OK';
        $responseObject->reference_id = array(
            '999QQ9QQQ9Q9999999999'
        );

        $from = '447860041446';
        $to = '447999999999,447999999998';
        $message = 'TEST MESSAGE';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->sendSms($from, $to, $message);

        $this->assertSame($responseObject->reference_id[0], $response);
    }
}
