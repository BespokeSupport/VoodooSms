<?php

use BespokeSupport\VoodooSmsTest\TestBaseClass;

/**
 * Class ApiDlrStatusTest.
 */
class ApiDlrStatusTest extends TestBaseClass
{
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testDlrFail()
    {
        $client = $this->getClient();
        $client->getDlrStatus();
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testDlrNotFound()
    {
        $responseObject = new stdClass();
        $responseObject->result = 401;
        $responseObject->error = 'UNAUTHORIZED';
        $reference_id = '999QQ9QQQ9Q9999999999';

        $client = $this->getClientWithException();

        $response = $client->getDlrStatus($reference_id);

        $this->assertSame($responseObject->result, $response->result);
    }

    public function testDlrOk()
    {
        $responseObject = new stdClass();
        $responseObject->result = '200 OK';
        $responseObject->delivery_status = 'Delivered';
        $responseObject->delivery_datetime = '2016-01-01 00:00:00';
        $responseObject->reference_id = '999QQ9QQQ9Q9999999999';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->getDlrStatus($responseObject->reference_id);

        $this->assertSame($responseObject->reference_id, $response->reference_id);
    }
}
