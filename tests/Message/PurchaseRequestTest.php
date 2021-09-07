<?php
namespace Omnipay\Paynow\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $buyer = [
            'email' => 'jan.nowak@melements.pl',
            'firstName' => 'Jan',
            'lastName' => 'Nowak',
            'phone' => [
                'number' => '123123123',
                'prefix' => '+48'
            ],
            'locale' => 'en-GB'
        ];

        $items[] = [
            'name' => 'Item name',
            'quantity' => '12',
            'category' => 'Category',
            'price' => '10'
        ];

        $this->request->initialize([
            'amount' => '10.00',
            'description' => 'Test description',
            'returnUrl' => 'https://paynow.pl',
            'transactionId' => '123',
            'buyer' => $buyer,
            'items' => $items,
            'paymentMethod' => '1000'
        ]);
    }

    public function testGetData()
    {
        //given

        //when
        $data = $this->request->getData();

        //then
        $this->assertSame(1000, $data['amount']);
        $this->assertSame('Test description', $data['description']);
        $this->assertSame('https://paynow.pl', $data['continueUrl']);
        $this->assertSame('123', $data['externalId']);
        $this->assertSame('1000', $data['paymentMethodId']);


        $this->assertSame('jan.nowak@melements.pl', $data['buyer']['email']);
        $this->assertSame('Jan', $data['buyer']['firstName']);
        $this->assertSame('Nowak', $data['buyer']['lastName']);
        $this->assertSame('en-GB', $data['buyer']['locale']);
        $this->assertSame('123123123', $data['buyer']['phone']['number']);
        $this->assertSame('+48', $data['buyer']['phone']['prefix']);

        $this->assertSame('Item name', $data['orderItems'][0]['name']);
        $this->assertSame('12', $data['orderItems'][0]['quantity']);
        $this->assertSame('Category', $data['orderItems'][0]['category']);
        $this->assertSame('10', $data['orderItems'][0]['price']);
    }

}
