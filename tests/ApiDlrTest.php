<?php

use BespokeSupport\VoodooSms\VoodooSmsException;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

/**
 * Class ApiDlrTest
 */
class ApiDlrTest extends TestBaseClass
{
    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testDlrDateFail()
    {
        $responseObject = new stdClass();
        $responseObject->result = 485;
        $responseObject->resultText = 'No Record Found';

        $client = $this->getClientWithException();

        $client->getDlr(true);
    }

    /**
     *
     */
    public function testDlrDateOk()
    {
        $responseArray = array();
        $responseObject = new stdClass();
        $responseObject->destination_number = '447894561234';
        $responseObject->delivery_status = 'Delivered';
        $responseObject->delivery_datetime = '2016-01-01 00:00:00';
        $responseObject->reference_id = '999QQ9QQQ9Q9999999999';
        $responseArray[] = $responseObject;

        $client = $this->getClientWithTestResponse($this->returnValue($responseArray));

        $response = $client->getDlr('2016-01-01');

        $this->assertCount(1, $response);
        $this->assertSame($responseObject->delivery_status, $response[0]->delivery_status);
    }

    /**
     *
     */
    public function testDlrFail()
    {
        $responseObject = new stdClass();
        $responseObject->result = 401;
        $responseObject->resultText = 'UNAUTHORIZED CHECK API USER';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->getDlr();

        $this->assertSame($responseObject->result, $response->result);
        $this->assertSame($responseObject->resultText, $response->resultText);
    }

    /**
     *
     */
    public function testDlrOk()
    {
        $responseArray = array();
        $responseObject = new stdClass();
        $responseObject->destination_number = '447894561234';
        $responseObject->delivery_status = 'Delivered';
        $responseObject->delivery_datetime = '2016-01-04 00:00:00';
        $responseObject->reference_id = '999QQ9QQQ9Q9999999999';
        $responseArray[] = $responseObject;

        $client = $this->getClientWithTestResponse($this->returnValue($responseArray));

        $response = $client->getDlr();

        $this->assertCount(1, $response);
        $this->assertSame($responseObject->delivery_status, $response[0]->delivery_status);
    }
}
