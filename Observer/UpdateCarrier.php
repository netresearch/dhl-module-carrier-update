<?php

/**
 * See LICENSE.md for license details.
 */

namespace Dhl\Paket\Observer;

use Dhl\Paket\Api\UpdateConditionInterface;
use Dhl\Paket\Model\Carrier\Paket;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateCarrier implements ObserverInterface
{
    /**
     * @var UpdateConditionInterface
     */
    private $condition;

    public function __construct(UpdateConditionInterface $condition)
    {
        $this->condition = $condition;
    }

    /**
     * When a new order is placed, set the DHL Paket carrier if applicable.
     *
     * Event:
     * - sales_order_place_after
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer): void
    {
        /** @var \Magento\Sales\Api\Data\OrderInterface|\Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');
        if ($order->getIsVirtual()) {
            // virtual orders cannot be shipped.
            return;
        }

        $shippingMethod = $order->getShippingMethod();
        if (strpos($shippingMethod, Paket::CARRIER_CODE) === 0) {
            // order is already assigned to DHL Paket.
            return;
        }

        if (!$this->condition->canUpdate($order)) {
            // any further condition(s) prevent the order from being updated.
            return;
        }


        $parts = explode('_', $shippingMethod);
        $parts[0] = Paket::CARRIER_CODE;
        $shippingMethod = implode('_', $parts);

        $order->setData('shipping_method', $shippingMethod);
    }
}
