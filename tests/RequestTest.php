<?php

use BespokeSupport\VoodooSms\VoodooSmsException;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

use BespokeSupport\VoodooSms\VoodooSmsClient;
use BespokeSupport\VoodooSms\VoodooSmsRequest;
use BespokeSupport\VoodooSms\VoodooSmsRequestAbstract;

/**
 * Class RequestTest
 */
class RequestTest extends TestBaseClass
{
    public function testInstance()
    {
        $client = VoodooSmsClient::getInstance('user', 'pass');
        $this->assertNotNull($client);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testFailAuthorised()
    {
        $responseObject = new stdClass();
        $responseObject->result = 401;
        $responseObject->error = 'UNAUTHORIZED';

        $client = $this->getClientWithException();

        $client->getCredit();
    }


    /**
     *
     */
    public function testJsonOk()
    {
        $json = '{key:"value"}';
        $decoded = json_decode($json);

        $data = VoodooSmsRequestAbstract::jsonDecodeCheck($json, array('format' => 'json'));

        $this->assertSame($decoded, $data);
    }

    /**
     *
     */
    public function testPhpOk()
    {
        $decoded = new stdClass();
        $decoded->key = 'value';
        $json = 'array("key"=>"value")';

        $data = VoodooSmsRequestAbstract::jsonDecodeCheck($json, array('format' => 'php'));

        $this->assertSame($decoded->key, $data->key);
    }

    /**
     *
     */
    public function testMethod()
    {
        $method = VoodooSmsRequestAbstract::getCallMethod(VoodooSmsRequestAbstract::METHOD_CURL);

        $this->assertSame($method, VoodooSmsRequestAbstract::METHOD_CURL);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testMethodFatal2()
    {
        VoodooSmsRequestAbstract::getCallMethod(false);
    }

    /**
     *
     */
    public function testMethodNonFatalNull()
    {
        VoodooSmsRequestAbstract::getCallMethod(null);
    }

    /**
     *
     */
    public function testRaw()
    {
        $return = <<<'TAG'
<xml>
<result>200 OK</result>
<credit>100.0000</credit>
</xml>
TAG;

        $data = VoodooSmsRequestAbstract::jsonDecodeCheck($return);

        $this->assertSame($return, $data);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testResponseFatal()
    {
        VoodooSmsRequest::getResponseStatic('unknown', array(), 'randomMethod');
    }

    /**
     *
     */
    public function testResponseNull()
    {
        VoodooSmsRequest::getResponseStatic('unknown', array(), 'testMethod');
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testStaticFail()
    {
        VoodooSmsClient::call();
    }

    /**
     *
     */
    public function testStaticOk()
    {
        VoodooSmsClient::call('getFormat');
    }

    /**
     *
     */
    public function testUri()
    {
        $this->assertSame('https://' . VoodooSmsRequest::URI, VoodooSmsRequest::getUriBase());
    }

    /**
     *
     */
    public function testUrl()
    {
        $url = VoodooSmsRequest::getUrl('test', array(
            'k1' => 'v1',
            'k2' => 'v2',
        ));

        $this->assertSame('https://' . VoodooSmsRequest::URI . 'test?k1=v1&k2=v2', $url);
    }

    /**
     *
     */
    public function testXml()
    {
        $return = <<<'TAG'
<xml>
<result>200 OK</result>
<credit>100.0000</credit>
</xml>
TAG;

        $data = VoodooSmsRequestAbstract::jsonDecodeCheck($return, array('format' => 'xml'));

        $this->assertSame($return, $data);
    }

    /**
     *
     */
    public function testFormat()
    {
        $set = 'php';

        $client = $this->getClient();
        $client->resultFormat = $set;

        $this->assertSame($set, $client->getFormat());
    }
}
