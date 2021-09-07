<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Purchase Response.
 */
class PurchaseResponse extends AbstractPaynowResponse implements RedirectResponseInterface
{

    public function getTransactionReference()
    {
        if ($paymentId = $this->get('paymentId')) {
            return $paymentId;
        }

        return null;
    }

    public function isRedirect()
    {
        $errors = $this->get('errors');

        return !$errors && $this->getRedirectUrl();
    }

    public function getRedirectUrl()
    {
        if ($redirectUrl = $this->get('redirectUrl')) {
            return $redirectUrl;
        }

        return null;
    }

    public function getStatus()
    {
        if ($status = $this->get('status')) {
            return $status;
        }

        return null;
    }
}
