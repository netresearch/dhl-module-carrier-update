<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Paket\Model\UpdateCondition;

use Dhl\Paket\Api\UpdateConditionInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Netresearch\ShippingCore\Api\Config\ShippingConfigInterface;

/**
 * Check if the shipping origin is located in Germany.
 */
class ShippingOrigin implements UpdateConditionInterface
{
    /**
     * @var ShippingConfigInterface
     */
    private $shippingConfig;

    public function __construct(ShippingConfigInterface $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function canUpdate(OrderInterface $order): bool
    {
        return ('DE' === $this->shippingConfig->getOriginCountry($order->getStoreId()));
    }
}
