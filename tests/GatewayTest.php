<?php
namespace Omnipay\Paynow;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
/** @var  Gateway */
protected $gateway;

public function setUp()
{
    $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
}

public function testPurchase()
{
    //given
    $this->setMockHttpResponse('PurchaseSuccess.txt');

    $buyer = ['email' => 'jan.nowak@melements.pl'];

    //when
    $request = $this->gateway->purchase([
        'amount' => '10.00',
        'description' => 'Test description',
        'transactionId' => '123',
        'buyer' => $buyer
    ]);

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\PurchaseRequest', $request);

    //when
    $response = $request->send();

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\PurchaseResponse', $response);

    $this->assertTrue($response->isRedirect());
    $this->assertEquals('https://paywall.sandbox.paynow.pl/NO67-123-PAY-NOW', $response->getRedirectUrl());
    $this->assertEquals('NO67-123-PAY-NOW', $response->getTransactionReference());
    $this->assertEquals('NEW', $response->getStatus());
    $this->assertNull($response->getMessage());

}

public function testRefund()
{
    //given
    $this->setMockHttpResponse('RefundSuccess.txt');

    //when
    $request = $this->gateway->refund(['amount' => '10.00', 'reason' => 'OTHER']);

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\RefundRequest', $request);

    //when
    $response = $request->send();

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\RefundResponse', $response);
    $this->assertSame('REF-123-PAY-NOW', $response->getRefundReference());
    $this->assertSame('SUCCESSFUL', $response->getStatus());
}


public function testAcceptNotification()
{
    // given

    //when
    $notification = $this->gateway->acceptNotification();

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\Notification', $notification);
}

public function testFetchPaymentsMethods()
{
    // given
    $this->setMockHttpResponse('FetchPaymentMethodsSuccess.txt');

    //when
    $request = $this->gateway->fetchPaymentMethods();

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\FetchPaymentMethodsRequest', $request);

    //when
    $response = $request->send();

    //then
    $this->assertInstanceOf('Omnipay\Paynow\Message\FetchPaymentMethodsResponse', $response);
}

public function testFetchTransaction()
{
	// given
	$this->setMockHttpResponse('FetchTransactionSuccess.txt');
	
	// when
	$request = $this->gateway->fetchTransaction([ 'transactionReference' => 'NOKZ-NVI-36D-9FQ' ]);
	
	// then
	$this->assertInstanceOf('Omnipay\Paynow\Message\FetchTransactionRequest', $request);
	
	// when
	$response = $request->send();
	
	// then
	$this->assertInstanceOf('Omnipay\Paynow\Message\FetchTransactionResponse', $response);
	$this->assertSame('NOKZ-NVI-36D-9FQ', $response->getTransactionReference());
	$this->assertSame('CONFIRMED', $response->getStatus());
}

}
