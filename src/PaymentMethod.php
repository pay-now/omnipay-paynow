<?php
/**
 * PaymentMethod
 */

namespace Omnipay\Paynow;

/**
 * PaymentMethod
 *
 * This class defines a paynow payment method to be used in the Omnipay system.
 */
class PaymentMethod extends \Omnipay\Common\PaymentMethod
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $type;

    public function __construct($id, $name, $description, $image, $status, $type)
    {
        parent::__construct($id, $name);
        $this->description = $description;
        $this->image = $image;
        $this->status = $status;
        $this->type = $type;
    }

    /**
     * The description of this payment method
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * The url for payment method icon of this payment method
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Current status of this payment method
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * The type of this payment method
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
