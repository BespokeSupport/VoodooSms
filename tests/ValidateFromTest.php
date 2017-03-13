<?php

use BespokeSupport\VoodooSms\VoodooSmsValidate;
use BespokeSupport\VoodooSmsTest\TestBaseClass;
use BespokeSupport\VoodooSmsTest\TestClass;

class ValidateFromTest extends TestBaseClass
{
    public function testString()
    {
        $number = 'Hello';
        $r = VoodooSmsValidate::numberFrom($number);
        $this->assertNotNull($r);
    }

    public function testNumber()
    {
        $number = 444;
        $r = VoodooSmsValidate::numberFrom($number);
        $this->assertNotNull($r);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testNull()
    {
        $number = null;
        VoodooSmsValidate::numberFrom($number);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testArray()
    {
        $number = [];
        VoodooSmsValidate::numberFrom($number);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testStringTooLong()
    {
        $number = 'ThisStringIsFarTooLong';
        VoodooSmsValidate::numberFrom($number);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testObject()
    {
        $number = new stdClass();
        $number->number = '01772123456';
        VoodooSmsValidate::numberFrom($number);
    }

    public function testObjectString()
    {
        $number = new TestClass();
        $number->number = 01772123456;

        $r = VoodooSmsValidate::numberFrom($number);
        $this->assertNotNull($r);
    }
}
