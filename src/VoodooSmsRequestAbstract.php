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
 * Class VoodooSmsRequestAbstract
 *
 * @category API
 * @package  BespokeSupport\VoodooSms
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
abstract class VoodooSmsRequestAbstract implements VoodooSmsRequestInterface
{
    /**
     * FGC
     */
    const METHOD_FGC = 'file_get_contents';
    /**
     * Curl
     */
    const METHOD_CURL = 'curl';

    /**
     * Methods available in this class
     *
     * @return array
     */
    public static function getMethodsAvailable()
    {
        return array(
            self::METHOD_FGC,
            self::METHOD_CURL,
        );
    }

    /**
     *  Base URL for API
     */
    const URI = 'www.voodoosms.com/vapi/server/';

    /**
     * Use HTTPS
     *
     * @return string
     */
    public static function getUriBase()
    {
        $protocol = 'https';

        return $protocol . '://' . VoodooSmsRequest::URI;
    }

    /**
     * Get complete URL
     *
     * @param string $method API Method being called
     * @param array  $args   Params
     *
     * @return string
     */
    public static function getUrl($method, $args = array())
    {
        $urlParams = static::getUriBase() . $method . '?' . http_build_query($args);
        return $urlParams;
    }

    /**
     * Decode to Array if possible
     *
     * @param string $response Raw Response
     * @param array  $params   Params to see what requested
     *
     * @return string|\stdClass|array
     */
    public static function jsonDecodeCheck($response, array $params = array())
    {
        if (empty($params['format'])) {
            return $response;
        }

        if ('json' == $params['format']) {
            $response = json_decode($response);
        }

        if ('php' == $params['format']) {
            $a = null;
            $e = "\$a = $response;";
            eval($e);
            $response = new \ArrayObject($a, \ArrayObject::ARRAY_AS_PROPS);
        }

        return $response;
    }

    /**
     * Method for accessing API FGC/Curl
     *
     * @param string $override curl/file_get_contents
     *
     * @return null|string
     * @throws VoodooSmsException
     */
    public static function getCallMethod($override = null)
    {
        // @codeCoverageIgnoreStart
        if (function_exists('curl_init') && is_null($override)) {
            return self::METHOD_CURL;
        }

        if (ini_get('allow_url_fopen') && is_null($override)) {
            return self::METHOD_FGC;
        }
        // @codeCoverageIgnoreEnd

        if (in_array($override, static::getMethodsAvailable())) {
            return $override;
        }

        throw new VoodooSmsException('No Method to access API');
    }
}
