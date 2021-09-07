<?php
namespace Omnipay\Paynow\Message;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /** @var RefundRequest */
    private $request;

    public function  setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'amount' => '100',
            'transactionReference' => 'NOW4-CK5-C3E-ZDM',
            'reason' => 'RMA'
        ]);
    }

    public function testGetData()
    {
        //given

        //when
        $data = $this->request->getData();

        //then
        $this->assertSame(10000, $data['amount']);
        $this->assertSame('RMA', $data['reason']);

        $endpoint = $this->request->getEndpoint();

        $this->assertContains('NOW4-CK5-C3E-ZDM', $endpoint);
    }
}
