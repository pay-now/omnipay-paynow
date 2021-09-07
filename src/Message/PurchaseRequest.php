<?php

namespace Omnipay\Paynow\Message;

use Omnipay\Paynow\Buyer;
use Omnipay\Paynow\PaynowItemBag;

/**
 * Purchase Request.
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractPaynowRequest
{
    /**
     * Get the buyer.
     *
     * @return Buyer
     */
    public function getBuyer()
    {
        return $this->getParameter('buyer');
    }

    /**
     * Sets the buyer.
     *
     * @param  Buyer|array $value
     * @return $this
     */
    public function setBuyer($value)
    {
        if ($value && !$value instanceof Buyer) {
            $value = new Buyer($value);
        }

        return $this->setParameter('buyer', $value);
    }

    /**
     * Get the cart items.
     *
     * @return PaynowItemBag
     */
    public function getItems()
    {
        return $this->getParameter('items');
    }

    /**
     * Sets the cart items.
     *
     * @param  PaynowItemBag|array $value
     * @return $this
     */
    public function setItems($value)
    {
        if ($value && !$value instanceof PaynowItemBag) {
            $value = new PaynowItemBag($value);
        }

        return $this->setParameter('items', $value);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        $data['amount'] = $this->getAmountInteger();
        $data['currency'] = $this->getCurrency();
        $data['externalId'] = $this->getTransactionId();
        $data['description'] = $this->getDescription();
        $data['continueUrl'] = $this->getReturnUrl();
        if ($buyer = $this->getBuyer()) {
            $data['buyer']['email'] = $buyer->getEmail();
            $data['buyer']['firstName'] = $buyer->getFirstName();
            $data['buyer']['lastName'] = $buyer->getLastName();
            $data['buyer']['locale'] = $buyer->getLocale();
            if ($phone = $buyer->getPhone()) {
                $data['buyer']['phone']['number'] = $phone->getNumber();
                $data['buyer']['phone']['prefix'] = $phone->getPrefix();
            }
        }
        if ($items = $this->getItems()) {
            $orderItems = [];
            foreach ($items as $item) {
                $orderItem = [];
                $orderItem['name'] = $item->getName();
                $orderItem['category'] = $item->getCategory();
                $orderItem['quantity'] = $item->getQuantity();
                $orderItem['price'] = $item->getPrice();
                $orderItems[] = $orderItem;
            }
            $data['orderItems'] = $orderItems;
        }

        if ($paymentMethod = $this->getPaymentMethod()) {
            $data['paymentMethodId'] = $paymentMethod;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getApiVersion() . '/payments';
    }

    /**
     * @param string $data
     *
     * @return PurchaseResponse
     */
    protected function createResponse($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
