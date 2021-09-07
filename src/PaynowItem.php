<?php
/**
 * Paynow Cart Item
 */

namespace Omnipay\Paynow;

use Omnipay\Common\Item;

/**
 * Paynow Cart Item
 *
 * This class defines a single paynow cart item in the Omnipay system.
 */
class PaynowItem extends Item
{
    /**
     * Gets the item's category.
     *
     * @return Phone
     */
    public function getCategory()
    {
        return $this->getParameter('category');
    }

    /**
     * Sets the item's category.
     *
     * @param  string $value
     * @return $this
     */
    public function setCategory($value)
    {
        return $this->setParameter('category', $value);
    }
}
