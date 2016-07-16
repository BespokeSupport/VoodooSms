# Voodoo SMS (Bulk SMS) API

[![Build Status](https://travis-ci.org/BespokeSupport/VoodooSms.svg?branch=master)](https://travis-ci.org/BespokeSupport/VoodooSms)
[![Coverage Status](https://coveralls.io/repos/github/BespokeSupport/VoodooSms/badge.svg)](https://coveralls.io/github/BespokeSupport/VoodooSms)
[![License](https://poser.pugx.org/bespoke-support/sms-voodoo/license)](https://packagist.org/packages/bespoke-support/sms-voodoo)
[![Latest Stable Version](https://poser.pugx.org/bespoke-support/sms-voodoo/version)](https://packagist.org/packages/bespoke-support/sms-voodoo)

Compatible with Version 2.8 (December 2015)
* Multiple Recipients
* Default Country

API Calls available
---
* getCredit
* getSMS
* getDlr
* getDlrStatus
* sendSms

Installation
---

```bash
composer require bespoke-support/sms-voodoo
```

Usage
---
```php
$response = VoodooSmsClient::call('sendSms', $user, $pass, 'Sender', '07998877666', 'Test Message');

$client = VoodooSmsClient::getInstance($user, $pass);
$response = $client->sendSms($from, $to, $message);

$to:
* array
* object (with __toString)
* string
* int
* comma separated string

$from:
* Number
* Text (upto 11 characters)
```
```
$response = VoodooSmsClient::call('getSms', $user, $pass, '2016-01-01', '2016-07-31');
```

License
---
MIT