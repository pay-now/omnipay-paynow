<?php

namespace Omnipay\Paynow\Message;

/**
 * Refund Response.
 */
class RefundResponse extends AbstractPaynowResponse
{
    /**
     * @return null|string
     */
    public function getRefundReference()
    {
        if ($refundId = $this->get('refundId')) {
            return $refundId;
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
