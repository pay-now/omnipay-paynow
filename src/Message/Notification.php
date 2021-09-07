<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Client;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Paynow\Util\SignatureCalculator;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

class Notification implements NotificationInterface
{
    /**
     * @var stdClass
     */
    private $data = null;

    /**
     * @var Request
     */
    private $httpRequest;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $signatureKey;

    public function __construct($httpRequest, $httpClient, $signatureKey)
    {
        $this->httpRequest = $httpRequest;
        $this->httpClient = $httpClient;
        $this->signatureKey = $signatureKey;
    }

    public function getSignatureKey()
    {
        return $this->signatureKey;
    }

    public function getData()
    {
        if (!$this->data) {
            $data = $this->httpRequest->getContent();
            $headerSignature = $this->httpRequest->headers->get('Signature');
            $signatureCalculator = new SignatureCalculator($this->getSignatureKey(), $data);
            $signature = $signatureCalculator->getHash();

            if ($signature != $headerSignature) {
                throw new InvalidResponseException("Signature mismatch");
            }

            $this->data = json_decode($data);
        }

        return $this->data;
    }

    public function getTransactionReference()
    {
        if ($data = $this->getData()) {
            return $data->paymentId;
        }

        return null;
    }

    public function getTransactionStatus()
    {
        if ($data = $this->getData()) {
            $status = $data->status;
            if ($status == 'CONFIRMED') {
                return NotificationInterface::STATUS_COMPLETED;
            } elseif ($status == 'NEW' || $status == 'PENDING') {
                return NotificationInterface::STATUS_PENDING;
            }
        }

        return NotificationInterface::STATUS_FAILED;
    }

    public function getMessage()
    {
        return null;
    }
}
