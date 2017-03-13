<?php

use BespokeSupport\VoodooSmsTest\TestBaseClass;

/**
 * Class ApiCreditTest.
 */
class ApiCreditTest extends TestBaseClass
{
    public function testCreditOk()
    {
        $responseObject = new stdClass();
        $responseObject->result = '200 OK';
        $responseObject->credit = '95.0000';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->getCredit();

        $this->assertSame($responseObject->result, $response->result);
        $this->assertSame($responseObject->credit, $response->credit);
    }
}
