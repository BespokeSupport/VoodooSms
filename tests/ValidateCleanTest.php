<?php

use BespokeSupport\VoodooSms\VoodooSmsValidate;
use BespokeSupport\VoodooSmsTest\TestBaseClass;

class ValidateCleanTest extends TestBaseClass
{
    public function testNumberAlpha()
    {
        $number = 'aaaaa';
        $r = VoodooSmsValidate::numberClean($number);
        $this->assertNotNull($r);
    }
}
