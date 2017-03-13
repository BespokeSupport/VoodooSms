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

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * Class VoodooSmsValidate.
 *
 * @category API
 *
 * @author   Richard Seymour <web@seymour.im>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @link     https://github.com/BespokeSupport/VoodooSms
 */
class VoodooSmsValidate
{
    /**
     * 2 char ISO.
     *
     * @var string
     */
    public static $country = 'GB';
    /**
     * International Dial code.
     *
     * @var string|int
     */
    public static $countryCode = '44';

    /**
     * Date.
     *
     * @param string $date             Date
     * @param bool   $exceptionOnError Throw
     *
     * @throws VoodooSmsException
     *
     * @return null
     */
    public static function dateOptionalTime($date, $exceptionOnError = true)
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}(\s\d{2}:\d{2}:\d{2})?$/', $date)) {
            if ($exceptionOnError) {
                throw new VoodooSmsException(VoodooSmsException::INVALID_DATE);
            } else {
                return;
            }
        }

        return $date;
    }

    /**
     * Clean Number.
     *
     * @param string $numberOriginal Number
     *
     * @return string
     */
    public static function numberClean($numberOriginal)
    {
        $numberCleaned = preg_replace('/[^\d,]/', '', (string) $numberOriginal);

        return $numberCleaned;
    }

    /**
     * Single/Multiple Number(s).
     *
     * @param string|array|int $number Number(s)
     *
     * @return bool
     */
    public static function isNumberMultiple($number)
    {
        if (is_array($number)) {
            return true;
        }

        return strpos($number, ',') !== false;
    }

    /**
     * Explode into array.
     *
     * @param string|array|int $number Number(s)
     *
     * @return array
     */
    public static function numberExplode($number)
    {
        if (is_array($number)) {
            return $number;
        }

        try {
            $number = (string) $number;
        } catch (\Exception $e) {
            return [];
        }

        if (static::isNumberMultiple($number)) {
            $numbers = explode(',', $number);
        } else {
            $numbers = [$number];
        }

        return $numbers;
    }

    /**
     * Validate with Google lib.
     *
     * @param array $numbers      Numbers
     * @param bool  $dumpFailures Include Failures
     *
     * @return array
     */
    public static function numbersValidate(
        array $numbers = [],
        $dumpFailures = false
    ) {
        $success = [];
        $failure = [];

        foreach ($numbers as $number) {
            $newNumber = static::numberValidate($number);
            if ($newNumber) {
                $success[] = $newNumber;
            } else {
                $failure[] = $number;
            }
        }

        if ($dumpFailures) {
            return  [
                $success,
                $failure,
            ];
        } else {
            return $success;
        }
    }

    /**
     * Validate single number.
     *
     * @param string|int $number         Number
     * @param bool       $throwException Throw
     *
     * @throws VoodooSmsException
     *
     * @return null|string
     */
    public static function numberValidate($number, $throwException = false)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parse($number, static::$country);
            $numberFormatted = $phoneUtil->format(
                $numberProto,
                PhoneNumberFormat::E164
            );
        } catch (\Exception $e) {
            $numberFormatted = null;
        }

        if ((!$numberFormatted || strlen($numberFormatted) < 8) && $throwException) {
            throw new VoodooSmsExceptionNumber(
                VoodooSmsExceptionNumber::INVALID_FORMAT
            );
        } else {
            // voodoo does not support E.164
            $numberFormatted = ltrim($numberFormatted, '+');

            return ($numberFormatted) ?: null;
        }
    }

    /**
     * Expect Multiple Numbers.
     *
     * @param array|int|string $numberOriginal Number(s)
     *
     * @return array
     */
    public static function numberMultiple($numberOriginal)
    {
        $numbers = static::numberExplode($numberOriginal);

        $numbers = static::numbersValidate($numbers);

        return $numbers;
    }

    /**
     * Expect Multiple numbers but show failures.
     *
     * @param array|int|string $numberOriginal Number(s)
     *
     * @return array
     */
    public static function numberMultipleSuccessFailure($numberOriginal)
    {
        $numbers = static::numberExplode($numberOriginal);

        $numbers = static::numbersValidate($numbers, true);

        return $numbers;
    }

    /**
     * Return Single Number.
     *
     * @param array|int|string $numberOriginal Number(s)
     *
     * @throws VoodooSmsException
     *
     * @return string
     */
    public static function numberSingle($numberOriginal)
    {
        $numbers = static::numberExplode($numberOriginal);

        $numbers = static::numbersValidate($numbers);

        if (count($numbers) != 1) {
            throw new VoodooSmsExceptionNumber(
                VoodooSmsExceptionNumber::NO_NUMBER_SENT
            );
        }

        return $numbers[0];
    }

    /**
     * From Number / String.
     *
     * @param int|string $numberOrString Number
     *
     * @throws VoodooSmsException
     *
     * @return string
     */
    public static function numberFrom($numberOrString)
    {
        if (is_array($numberOrString)) {
            throw new VoodooSmsException('From an array');
        }

        if (is_object($numberOrString)
            && !is_callable([$numberOrString, '__toString'])
        ) {
            throw new VoodooSmsExceptionNumber(
                VoodooSmsExceptionNumber::INVALID_FORMAT
            );
        }

        $cleaned = preg_replace('/[^\d\w]/', '', (string) $numberOrString);

        if (preg_match('/[A-Za-z]/', $cleaned)) {
            if (strlen($cleaned) > 11) {
                throw new VoodooSmsExceptionNumber(
                    VoodooSmsExceptionNumber::INVALID_LENGTH
                );
            }

            return $cleaned;
        }

        $number = static::numberValidate($cleaned);

        if (!$number) {
            throw new VoodooSmsExceptionNumber(
                VoodooSmsExceptionNumber::INVALID_FORMAT
            );
        }

        return $number;
    }
}
