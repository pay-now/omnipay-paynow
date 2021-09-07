<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Paynow\Util\SignatureCalculator;

/**
 * Abstract Paynow Request.
 */
abstract class AbstractPaynowRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected $sandboxEndpoint = 'https://api.sanddbox.paynow.pl/';

    /**
     * @var string
     */
    protected $productionEndpoint = 'https://api.sandbox.paynow.pl/';

    /**
     * @var string
     */
    protected $userAgent = 'omnipay-paynow';

    /**
     * @var string
     */
    protected $apiVersion = 'v1';

    /**
     * Get HTTP Method.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return null|string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return null|string
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
     * @param string $data
     *
     * @return string
     */
    public function sendData($data)
    {
        if ($this->getHttpMethod() == 'GET') {
            $url = $this->getEndpoint() . '?' . http_build_query($data);
            $body = null;
        } else {
            $body = json_encode($data);
            $url = $this->getEndpoint();
        }

        $headers = $this->prepareHeaders($data);

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $url, $headers, $body);

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->sandboxEndpoint : $this->productionEndpoint;
    }

    /**
     * @return string
     */
    protected function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return string
     */
    protected function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @return string
     */
    protected function getIdempotencyKey()
    {
        return null;
    }

    /**
     * @param  null|array $data
     * @return array
     */
    private function prepareHeaders($data = null)
    {
        $headers = [
            'Api-Key' => $this->getApiKey(),
            'User-Agent' => $this->getUserAgent(),
            'Idempotency-Key' => uniqid(),
            'Accept' => 'application/json'
        ];

        if ($data) {
            $headers['Content-Type'] = 'application/json';
            $signatureCalculator = new SignatureCalculator($this->getSignatureKey(), json_encode($data));
            $signature = $signatureCalculator->getHash();

            $headers['Signature'] = $signature;
        }

        if ($idempotencyKey = $this->getIdempotencyKey()) {
            $headers['Idempotency-Key'] = $idempotencyKey;
        }

        return $headers;
    }
}
