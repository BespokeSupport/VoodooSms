<?php

use BespokeSupport\VoodooSmsTest\TestBaseClass;

/**
 * Class ApiSmsGetTest
 */
class ApiSmsGetTest extends TestBaseClass
{
    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testFail()
    {
        $client = $this->getClient();
        $client->getSms();
    }

    /**
     *
     */
    public function testOk()
    {
        $responseObject = new stdClass();
        $responseObject->result = '200 OK';
        $responseObject->messages = array();

        $messageObject = new stdClass();
        $messageObject->Message = 'TEST MESSAGE';
        $messageObject->TimeStamp = '2016-01-02 00:00:00';
        $messageObject->Originator = '447709900000';

        $responseObject->messages[] = $messageObject;

        $from = '2016-01-01';
        $to = '2016-08-01';

        $client = $this->getClientWithTestResponse($this->returnValue($responseObject));

        $response = $client->getSms($from, $to);

        $this->assertSame($responseObject->result, $response->result);
        $this->assertCount(1, $response->messages);
        $this->assertSame($messageObject->Message, $response->messages[0]->Message);
    }
}
