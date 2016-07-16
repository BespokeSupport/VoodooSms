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
 * Class VoodooSmsClient
 *
 * @category API
 * @package  BespokeSupport\VoodooSms
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
class VoodooSmsClient
{
    /**
     * ISO 2 char country
     *
     * @var string
     */
    protected $defaultCountry;
    /**
     * API password
     *
     * @var string
     */
    protected $pass;
    /**
     * API username
     *
     * @var string
     */
    protected $user;
    /**
     * Format to return the result json/php/xml
     *
     * @var string
     */
    public $resultFormat;
    /**
     * Client used to access API
     *
     * @var VoodooSmsRequestInterface
     */
    public $client;
    /**
     * Throw Exceptions?
     *
     * @var bool
     */
    public $exceptionOnError = true;

    /**
     * VoodooSmsClient constructor.
     *
     * @param string     $user           Username
     * @param string     $pass           Password
     * @param int|string $defaultCountry International dial code
     */
    public function __construct($user, $pass, $defaultCountry = 44)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->defaultCountry = $defaultCountry;

        $this->client = new VoodooSmsRequest();
    }

    /**
     * Static call()
     *
     * @return mixed
     * @throws VoodooSmsException
     */
    public static function call()
    {
        $args = func_get_args();

        $method = array_shift($args);
        $user = array_shift($args);
        $pass = array_shift($args);

        $client = new self($user, $pass);

        if (!$method || !method_exists($client, $method)) {
            throw new VoodooSmsException('Cannot access method');
        }

        return call_user_func_array(
            array(
                $client,
                $method
            ),
            $args
        );
    }

    /**
     * Return Format
     *
     * @return string
     */
    public function getFormat()
    {
        if ($this->resultFormat) {
            return $this->resultFormat;
        }

        return static::getFormatFunction();
    }

    /**
     * Formats available
     *
     * @return string
     */
    public static function getFormatFunction()
    {
        return (function_exists('json_decode')) ? 'json' : 'php';

    }

    /**
     * Default params
     *
     * @return array
     */
    public function getParamsDefault()
    {
        return array(
            'uid' => $this->user,
            'pass' => $this->pass,
            'format' => $this->getFormat(),
        );
    }

    /**
     * Merge default with passed
     *
     * @param array $params Params
     *
     * @return array
     */
    public function getParams(array $params = array())
    {
        return array_merge(
            $this->getParamsDefault(),
            $params
        );
    }

    /**
     * New class()
     *
     * @param string $user API Username
     * @param string $pass API Password
     *
     * @return VoodooSmsClient
     */
    public static function getInstance($user, $pass)
    {
        $client = new self($user, $pass);

        return $client;
    }

    /**
     * Send SMS
     *
     * @param string           $user API Username
     * @param string           $pass API Password
     * @param int|string       $from From Number / String
     * @param int|string|array $to   Numbers
     * @param string           $msg  Message
     *
     * @return array|string
     *
     * @codeCoverageIgnore
     */
    public static function send($user, $pass, $from, $to, $msg)
    {
        $from = VoodooSmsValidate::numberFrom($from);

        $toArray = VoodooSmsValidate::numberMultiple($to);
        $numbers = implode(',', $toArray);

        $params = array(
            'format' => VoodooSmsClient::getFormatFunction(),
            'cc' => VoodooSmsValidate::$countryCode,
            'user' => $user,
            'pass' => $pass,
            'orig' => $from,
            'dest' => $numbers,
            'msg' => $msg,
        );

        $response = (new VoodooSmsRequest())->getResponse('sendSms', $params);

        return $response->reference_id[0];
    }

    /**
     * Send SMS
     *
     * @param int|string       $from From Number / String
     * @param int|string|array $to   Numbers
     * @param string           $msg  Message
     *
     * @return array|string
     */
    public function sendSms($from, $to, $msg)
    {
        $from = VoodooSmsValidate::numberFrom($from);

        $toArray = VoodooSmsValidate::numberMultiple($to);
        $numbers = implode(',', $toArray);

        $params = array(
            'orig' => $from,
            'dest' => $numbers,
            'msg' => $msg,
            'cc' => $this->defaultCountry,
        );

        $params = $this->getParams($params);

        $response = $this->client->getResponse('sendSms', $params);

        return $response->reference_id[0];
    }

    /**
     * Get Deliveries
     *
     * @param null $date Date
     *
     * @return array|string|\stdClass
     */
    public function getDlr($date = null)
    {
        if (!$date) {
            $date = (new \DateTime())->format('Y-m-d');
        }

        $date = VoodooSmsValidate::dateOptionalTime($date);

        $params = array(
            'date' => $date,
        );

        $params = $this->getParams($params);

        $response = $this->client->getResponse('getDlr', $params);

        return $response;
    }

    /**
     * Get status of Single Message
     *
     * @param string $reference Reference
     *
     * @return array|string
     */
    public function getDlrStatus($reference)
    {
        $params = array(
            'reference_id' => $reference,
        );

        $params = $this->getParams($params);

        $response = $this->client->getResponse('getDlrStatus', $params);

        return $response;
    }

    /**
     * Get Credit
     *
     * @return \stdClass|string
     */
    public function getCredit()
    {
        $params = array();

        $params = $this->getParams($params);

        $response = $this->client->getResponse('getCredit', $params);

        return $response;
    }

    /**
     * Get Incoming SMSs
     *
     * @param string $dateFrom From Date (2016-01-01)
     * @param string $dateTo   To Date (2016-01-01)
     *
     * @return array|string
     */
    public function getSms($dateFrom, $dateTo)
    {
        $params = array(
            'from' => $dateFrom,
            'to' => $dateTo,
        );

        $params = $this->getParams($params);

        $response = $this->client->getResponse('getSMS', $params);

        return $response;
    }
}
