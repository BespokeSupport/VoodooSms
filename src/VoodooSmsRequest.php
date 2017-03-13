<?php

/**
 * VoodooSms API Client.
 *
 * PHP version 5
 *
 * LICENSE: MIT
 *
 * @category API
 *
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @link     https://github.com/BespokeSupport/VoodooSms
 */

namespace BespokeSupport\VoodooSms;

/**
 * Class VoodooSmsRequest.
 *
 * @category API
 *
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
class VoodooSmsRequest extends VoodooSmsRequestAbstract
{
    /**
     * Get Response.
     *
     * @param string $method API Method being called
     * @param array  $params Params
     *
     * @throws VoodooSmsException
     *
     * @return array|string
     */
    public function getResponse($method, array $params = [])
    {
        $response = self::getResponseStatic($method, $params);

        $response = static::jsonDecodeCheck($response, $params);

        if (is_object($response)) {
            if (!empty($response->result)) {
                if ($response->result != 200) {
                    $message = (!empty($response->resultText)) ?
                        $response->resultText :
                        'no message';
                    throw new VoodooSmsException($message);
                }
            }

            if (!empty($response->status)) {
                if ($response->status != 200) {
                    $message = (!empty($response->message)) ?
                        $response->message :
                        'no message';
                    throw new VoodooSmsException($message);
                }
            }
        }

        return $response;
    }

    /**
     * Get Response.
     *
     * @param string $method     API Method being called
     * @param array  $params     Params
     * @param null   $callMethod Curl / FGC
     *
     * @throws VoodooSmsException
     *
     * @return \stdClass|string
     */
    public static function getResponseStatic(
        $method,
        array $params = [],
        $callMethod = null
    ) {
        $url = static::getUrl($method, $params);

        $callMethod = ($callMethod) ?: VoodooSmsRequestAbstract::getCallMethod();

        switch ($callMethod) {
        case VoodooSmsRequestAbstract::METHOD_FGC:
                $opts = [
                    'http' => [
                        'method' => 'GET',
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                    ],
                ];

                $context = stream_context_create($opts);

                $response = file_get_contents($url, null, $context);
                if ($response === false && error_get_last()) {
                    throw new VoodooSmsException('Could not access API');
                }

            break;
        case VoodooSmsRequestAbstract::METHOD_CURL:
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                $response = curl_exec($ch);
            break;
        case 'testMethod':
                $response = '';
            break;
        default:
            throw new VoodooSmsException('No Method to access API');
        }

        return $response;
    }
}
