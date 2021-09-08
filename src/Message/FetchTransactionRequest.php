<?php

namespace Omnipay\Paynow\Message;

/**
 * Fetch Transaction Request
 */
class FetchTransactionRequest extends AbstractPaynowRequest
{
    
    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate('transactionReference');
        
        return [];
    }
    
    /**
     * @inheritDoc
     */
    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getApiVersion() . '/payments/' . $this->getTransactionReference() . '/status';
    }
    
    /**
     * @param $data
     * @return FetchTransactionResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new FetchTransactionResponse($this, $data);
    }
    
    /**
     * @inheritDoc
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }
    
}