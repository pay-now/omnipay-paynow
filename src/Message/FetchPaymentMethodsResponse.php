<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Common\Message\FetchPaymentMethodsResponseInterface;
use Omnipay\Paynow\PaymentMethod;

/**
 * Fetch Payment Methods Response.
 */
class FetchPaymentMethodsResponse extends AbstractPaynowResponse implements FetchPaymentMethodsResponseInterface
{
    /**
     * @return null|PaymentMethod[]
     */
    public function getPaymentMethods()
    {
        if ($this->getData()) {
            $paymentMethods = [];
            foreach ($this->getData() as $paymentMethodsTypes) {
                $type = $paymentMethodsTypes->type;
                foreach ($paymentMethodsTypes->paymentMethods as $paymentMethod) {
                    $paymentMethod =  new PaymentMethod(
                        $paymentMethod->id,
                        $paymentMethod->name,
                        $paymentMethod->description,
                        $paymentMethod->image,
                        $paymentMethod->status,
                        $type
                    );
                    $paymentMethods[] = $paymentMethod;
                }
            }
            return $paymentMethods;
        }

        return null;
    }
}
