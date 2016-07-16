<?php

use BespokeSupport\VoodooSms\VoodooSmsValidate;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

class ValidateDateTest extends TestBaseClass
{
    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testDateAlpha()
    {
        $number = 'aaaaa';
        VoodooSmsValidate::dateOptionalTime($number);
        $this->assertTrue(false);
    }

    public function testDateAlphaNull()
    {
        $number = 'aaaaa';
        $r = VoodooSmsValidate::dateOptionalTime($number, false);
        $this->assertNull($r);
    }

    public function testDateOk()
    {
        $number = '2016-01-01';
        $r = VoodooSmsValidate::dateOptionalTime($number);
        $this->assertNotNull($r);
    }

    public function testDateTimeOk()
    {
        $number = '2016-01-01 00:00:00';
        $r = VoodooSmsValidate::dateOptionalTime($number);
        $this->assertNotNull($r);
    }
}
