<?php

namespace Omnipay\Paynow\Message;

/**
 * Refund Request.
 *
 * @method RefundResponse send()
 */
class RefundRequest extends AbstractPaynowRequest
{
    /**
     * Gets the reason.
     *
     * @return string
     */
    public function getReason()
    {
        return $this->getParameter('reason');
    }

    /**
     * Sets the reason.
     *
     * @param  string $value
     * @return $this
     */
    public function setReason($value)
    {
        return $this->setParameter('reason', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        $data['amount'] = $this->getAmountInteger();
        $data['reason'] = $this->getReason();

        return $data;
    }

    /**
     * @param string $data
     *
     * @return RefundResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new RefundResponse($this, $data);
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getApiVersion() . '/payments/' .$this->getTransactionReference() . '/refunds';
    }
}
