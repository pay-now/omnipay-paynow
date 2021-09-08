# Omnipay: Paynow

[![Build Status](https://travis-ci.com/pay-now/omnipay-paynow.svg?branch=master)](https://travis-ci.com/pay-now/omnipay-paynow)
[![Latest Version](https://img.shields.io/github/release/pay-now/omnipay-paynow.svg?style=flat-square)](https://github.com/pay-now/omnipay-paynow/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

**Paynow driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements paynow support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `pay-now/omnipay-paynow` with Composer:

```
composer require league/omnipay pay-now/omnipay-paynow
```


## Basic Usage

Making a payment:

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paynow');
$gateway->setApiKey('api-key');
$gateway->setSignatureKey('signature-key');

$buyer = [
    'email' => 'jan.nowak@melements.pl', 
    'firstName' => 'Jan', 
    'lastName' => 'Nowak', 
    'phone' => [
        'number' => '123123123', 
        'prefix' => '+48'
    ], 
    'locale'=> 'en-EN'
];

$items[] = [
    'name' => 'itemName', 
    'quantity' => '12', 
    'category' => 'toys', 
    'price' => '123'
];

$paymentData = [
    'amount' => '10000', 
    'description' => 'PLN', 
    'returnUrl' => 'https://paynow.pl', 
    'transactionId' => '123',   
    'buyer' => $buyer, 
    'items' => $items
];

try {
    $response = $gateway->purchase($paymentData)->send();
} catch (\Exception $e) {
    // catch errors
}
```

Handling notification with current payment status:

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paynow');
$gateway->setApiKey('api-key');
$gateway->setSignatureKey('signature-key');

try {
    $response = $gateway->acceptNotification();
} catch (\Exception $e) {
    header('HTTP/1.1 400 Bad Request', true, 400);
}

header('HTTP/1.1 202 Accepted', true, 202);
```

Making a payment's refund

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paynow');
$gateway->setApiKey('api-key');
$gateway->setSignatureKey('signature-key');

$refundData = [
    'amount' => '1000000', 
    'transactionReference' => 'NOW8-CK5-C3E-ZDM', 
    'reason' => 'RMA'
];

try {
    $response = $gateway->refund($refundData)->send();
} catch (\Exception $e) {
    // catch errors
}
```

Retrieving available payment methods

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paynow');
$gateway->setApiKey('api-key');
$gateway->setSignatureKey('signature-key');

$requestData = [
    'amount'=>'1000', 
    'currency'=> 'PLN'
];

try {
    $response = $gateway->fetchPaymentMethods($requestData)->send();
} catch (\Exception $e) {
    // catch errors
}
```


For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you have any questions or issues regarding paynow, please contact our support at support@paynow.pl.

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/thephpleague/omnipay-paypal/issues),
or better yet, fork the library and submit a pull request.
