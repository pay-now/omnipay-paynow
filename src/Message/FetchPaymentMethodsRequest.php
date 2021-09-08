<?php

namespace Omnipay\Paynow\Message;

/**
 * Fetch Payment Methods Request.
 *
 * @method FetchPaymentMethodsResponse send()
 */
class FetchPaymentMethodsRequest extends AbstractPaynowRequest
{

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = $this->getCurrency();

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getApiVersion() . '/payments/paymentmethods';
    }

    /**
     * @param string $data
     *
     * @return FetchPaymentMethodsResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new FetchPaymentMethodsResponse($this, $data);
    }

    protected function getHttpMethod()
    {
        return 'GET';
    }
}
