<?php
/**
 * Paynow Item Bag
 */

namespace Omnipay\Paynow;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

class PaynowItemBag extends ItemBag
{
    public function add($item)
    {
        if ($item instanceof PaynowItem) {
            $this->items[] = $item;
        } else {
            $this->items[] = new PaynowItem($item);
        }
    }
}
