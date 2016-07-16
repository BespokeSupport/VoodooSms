<?php

use BespokeSupport\VoodooSms\VoodooSmsValidate;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

class ValidateMultipleTest extends TestBaseClass
{
    public function testNumberMultipleArray()
    {
        $number = array(
            '01772123456',
            '07894561234'
        );
        $success = VoodooSmsValidate::numberMultiple($number);
        $this->assertNotNull($success);
        $this->assertCount(2, $success);
    }

    public function testNumberMultipleString()
    {
        $number = '01772123456,07894561234';
        $success = VoodooSmsValidate::numberMultiple($number);
        $this->assertNotNull($success);
        $this->assertCount(2, $success);
    }

    public function testIsMultipleArray()
    {
        $number = array(
            '01772123456',
            '07894561234'
        );
        $success = VoodooSmsValidate::isNumberMultiple($number);
        $this->assertTrue($success);
    }

    public function testIsMultipleString()
    {
        $number = '01772123456,07894561234';
        $success = VoodooSmsValidate::isNumberMultiple($number);
        $this->assertTrue($success);
    }

    public function testIsMultipleFalse()
    {
        $number = '01772123456';
        $r = VoodooSmsValidate::isNumberMultiple($number);
        $this->assertFalse($r);
    }


    public function testIsMultipleFail()
    {
        $number = new \stdClass();
        $success = VoodooSmsValidate::numberMultiple($number);
        $this->assertNotNull($success);
        $this->assertCount(0, $success);
    }

    public function testMultipleWithNoFails()
    {
        $numbers = '01772123456,07894561234';
        list($success, $failure) = VoodooSmsValidate::numberMultipleSuccessFailure($numbers);
        $this->assertNotNull($success);
        $this->assertNotNull($failure);
        $this->assertCount(2, $success);
        $this->assertCount(0, $failure);
    }
}
