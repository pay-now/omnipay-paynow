<?php
/**
 * Cart Item
 */

namespace Omnipay\Paynow;

use Symfony\Component\HttpFoundation\ParameterBag;

use Omnipay\Common\ParametersTrait;
use Omnipay\Common\Helper;

/**
 * Phone
 *
 * This class defines a buyers phone in the Omnipay system.
 */
class Phone
{
    use ParametersTrait;

    /**
     * Create a new phone with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on the new object
     */
    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize this phone with the specified parameters
     *
     * @param  array|null $parameters An array of parameters to set on this object
     * @return $this Item
     */
    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag();

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Gets the phone's prefix
     */
    public function getPrefix()
    {
        return $this->getParameter('prefix');
    }
    
    /**
     * Sets the buyer's phone.
     *
     * @param  string $value
     * @return $this
     */
    public function setPrefix($value)
    {
        return $this->setParameter('prefix', $value);
    }

    /**
     * Gets the phone's number
     */
    public function getNumber()
    {
        return $this->getParameter('number');
    }

    /**
     * Sets the buyer's phone.
     *
     * @param  string $value
     * @return $this
     */
    public function setNumber($value)
    {
        return $this->setParameter('number', $value);
    }
}
