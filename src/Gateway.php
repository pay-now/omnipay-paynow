<?php

namespace Omnipay\Paynow;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Paynow\Message\FetchPaymentMethodsRequest;
use Omnipay\Paynow\Message\Notification;
use Omnipay\Paynow\Message\PurchaseRequest;
use Omnipay\Paynow\Message\RefundRequest;

/**
 * Paynow Gateway.
 */
class Gateway extends AbstractGateway
{

    public function getName()
    {
        return 'Paynow';
    }

    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
            'signatureKey' => '',
            'testMode' => false,
        ];
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return string
     */
    public function getSignatureKey()
    {
        return $this->getParameter('signatureKey');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSignatureKey($value)
    {
        return $this->setParameter('signatureKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|FetchPaymentMethodsRequest
     */
    public function fetchPaymentMethods(array $parameters = [])
    {
        return $this->createRequest(FetchPaymentMethodsRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|RefundRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @return Notification
     */
    public function acceptNotification()
    {
        return new Notification($this->httpRequest, $this->httpClient, $this->getSignatureKey());
    }
}
