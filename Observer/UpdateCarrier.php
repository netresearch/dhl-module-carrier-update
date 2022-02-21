<?php

namespace Dhl\Paket\Observer;

use Dhl\Paket\Model\Carrier\Paket;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateCarrier implements ObserverInterface
{
    /**
     * @var ModuleConfigInterface
     */
    private $config;

    public function __construct(ModuleConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * When a new order is placed, set the DHL Paket carrier if applicable.
     *
     * Event:
     * - sales_order_place_after
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Api\Data\OrderInterface|\Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');
        if ($order->getIsVirtual()) {
            return;
        }

        $shippingMethod = $order->getShippingMethod();
        $recipientCountry = $order->getShippingAddress()->getCountryId();

        if ($this->config->canProcessShipping($shippingMethod, $recipientCountry, $order->getStoreId())) {
            $parts          = explode('_', $shippingMethod);
            $parts[0]       = Paket::CARRIER_CODE;
            $shippingMethod = implode('_', $parts);
            $order->setData('shipping_method', $shippingMethod);
        }
    }
}
