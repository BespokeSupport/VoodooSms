<?php

use BespokeSupport\VoodooSms\VoodooSmsValidate;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

class ValidateNumberTest extends TestBaseClass
{
    public function testNumberAlpha()
    {
        $number = 'aaaaa';
        $r = VoodooSmsValidate::numberValidate($number);
        $this->assertNull($r);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testNumberAlphaNull()
    {
        $number = 'aaaaa';
        VoodooSmsValidate::numberValidate($number, true);
    }

    public function testNumberOk()
    {
        $number = '01772123456';
        $r = VoodooSmsValidate::numberValidate($number);
        $this->assertNotNull($r);
    }

    public function testNumberSingle()
    {
        $number = '01772123456';
        $r = VoodooSmsValidate::numberSingle($number);
        $this->assertNotNull($r);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testNumberMultipleString()
    {
        $number = '01772123456,07894561234';
        VoodooSmsValidate::numberSingle($number);
    }

    /**
     * @expectedException BespokeSupport\VoodooSms\VoodooSmsException
     */
    public function testIsMultipleArray()
    {
        $number = [
            '01772123456',
            '07894561234',
        ];
        VoodooSmsValidate::numberSingle($number);
    }
}
