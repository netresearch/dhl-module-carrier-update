<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Paket\Api;

use Magento\Sales\Api\Data\OrderInterface;

/**
 * Test whether an order can be assigned to the DHL Paket carrier.
 */
interface UpdateConditionInterface
{
    public function canUpdate(OrderInterface $order): bool;
}
