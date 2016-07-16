<?php

/**
 * VoodooSms API Client
 *
 * PHP version 5
 *
 * LICENSE: MIT
 *
 * @category API
 * @package  VoodooSMS
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */

namespace BespokeSupport\VoodooSms;

/**
 * Class VoodooSmsExceptionNumber
 *
 * @category API
 * @package  BespokeSupport\VoodooSms
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
class VoodooSmsExceptionNumber extends VoodooSmsException
{
    const INVALID_LENGTH = 'Number invalid length';
    const INVALID_FORMAT = 'Number invalid format';
    const NO_NUMBER_SENT = 'No number sent';
}
