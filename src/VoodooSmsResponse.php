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
 * Class VoodooSmsResponse
 *
 * @category API
 * @package  BespokeSupport\VoodooSms
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
class VoodooSmsResponse
{
    /**
     * Success HTTP Codes + Message
     *
     * @var array
     */
    public static $successCodes = array(
        '200 OK'
    );

    /**
     * Error HTTP Codes + Message
     *
     * @var array
     */
    public static $errorCodes = array(
        '400 Bad request',
        '401 Unauthorized',
        '402 Not enough credit',
        '403 Forbidden',
        '406 Not Acceptable',
        '485 No Record Found',
        '488 Not Acceptable',
        '513 Message Too Large',
    );
}
