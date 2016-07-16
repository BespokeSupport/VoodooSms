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
 * Interface VoodooSmsRequestInterface
 *
 * @category API
 * @package  BespokeSupport\VoodooSms
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
interface VoodooSmsRequestInterface
{
    /**
     * Get Response
     *
     * @param string $method API Method being called
     * @param array  $params Params
     *
     * @return array|string
     */
    public function getResponse($method, array $params = array());
}
