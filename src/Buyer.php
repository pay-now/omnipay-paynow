<?php
/**
 * Buyer
 */

namespace Omnipay\Paynow;

use Symfony\Component\HttpFoundation\ParameterBag;

use Omnipay\Common\ParametersTrait;
use Omnipay\Common\Helper;

/**
 * Buyer
 *
 * This class defines a buyer's in the Omnipay system.
 */
class Buyer
{
    use ParametersTrait;

    /**
     * Create a new buyer's with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on the new object
     */
    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize this buyer's with the specified parameters
     *
     * @param  array|null $parameters An array of parameters to set on this object
     * @return $this Buyer
     */
    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag();

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Gets the buyer's first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    /**
     * Sets the buyer's first name.
     *
     * @param  string $value
     * @return $this
     */
    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    /**
     * Gets the buyer's first name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->getParameter('lastName');
    }

    /**
     * Sets the buyer's last name.
     *
     * @param  string $value
     * @return $this
     */
    public function setLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }

    /**
     * Gets the buyer's first name.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Sets the buyer's email.
     *
     * @param  string $value
     * @return $this
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * Gets the buyer's first name.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Sets the buyer's locale.
     *
     * @param  string $value
     * @return $this
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Gets the buyer's phone.
     *
     * @return Phone
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * Sets the buyer's phone.
     *
     * @param  Phone|array $value
     * @return $this
     */
    public function setPhone($value)
    {
        if ($value && !$value instanceof Phone) {
            $value = new Phone($value);
        }

        return $this->setParameter('phone', $value);
    }
}
