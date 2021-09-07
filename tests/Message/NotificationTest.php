<?php
namespace Omnipay\Paynow\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Tests\TestCase;

class NotificationTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    /** @var string */
    private $signatureKey = 'b305b996-bca5-4404-a0b7-2ccea3d2b64b';

    /**
     * @var Notification
     */
    private $notification;

    public function prepareTestCase($signature)
    {
        $server = [
                'HTTP_Content-Type'=>'application/json',
                'HTTP_Signature' => $signature
        ];

        $content = file_get_contents(dirname(__FILE__).'/../resources/notification.json');

        $this->getHttpRequest()->initialize([],[],[],[],[],$server, $content);

        $this->notification = new Notification($this->getHttpRequest(), $this->getHttpClient(), $this->signatureKey);
    }

    public function testGetData()
    {
        //given
        $signature = 'F69sbjUxBX4eFjfUal/Y9XGREbfaRjh/zdq9j4MWeHM=';
        $this->prepareTestCase($signature);

        //when
        $data = $this->notification->getData();

        //then
        $this->assertSame('NOLV-8F9-08K-WGD', $data->paymentId);
        $this->assertSame('9fea23c7-cd5c-4884-9842-6f8592be65df', $data->externalId);
        $this->assertSame('CONFIRMED', $data->status);
    }

    public function testShouldThrowExceptionOnIncorrectSignature()
    {
        //given
        $signature = 'hrJfWmCBf5qAafHIqYjju+thqdfFKMBMPpWXi/xX4/w=';
        $this->prepareTestCase($signature);
        $this->expectException(InvalidResponseException::class);

        //when
        $this->notification->getData();
    }
}
