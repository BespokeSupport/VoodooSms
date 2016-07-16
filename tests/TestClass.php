<?php

namespace BespokeSupport\VoodooSmsTest;

/**
 * Class TestClass
 * @package BespokeSupport\VoodooSmsTest
 */
class TestClass
{
    /**
     * @var int|string
     */
    public $number;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->number;
    }
}
