<?php

namespace Omnipay\Paynow\Message;

/**
 * Fetch Transaction Response.
 */
class FetchTransactionResponse extends AbstractPaynowResponse
{
    /**
     * @return null|string
     */
    public function getPaymentId()
    {
        if ($paymentId = $this->get('paymentId')) {
            return $paymentId;
        }

        return null;
    }

    /**
     * @return null|string
     */
    public function getStatus()
    {
        if ($status = $this->get('status')) {
            return $status;
        }

        return null;
    }
}
