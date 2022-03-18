<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Paket\Model\UpdateCondition;

use Dhl\Paket\Api\UpdateConditionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Check if the order's shipping method is configured for DHL Paket carrier assignment.
 */
class MethodConfiguration implements UpdateConditionInterface
{
    private const CONFIG_PATH_ADDITIONAL_METHODS = 'dhlshippingsolutions/dhlpaket/checkout_settings/methods_additional';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function canUpdate(OrderInterface $order): bool
    {
        $configuredMethods = (string) $this->scopeConfig->getValue(
            self::CONFIG_PATH_ADDITIONAL_METHODS,
            ScopeInterface::SCOPE_STORE,
            $order->getStoreId()
        );

        $configuredMethods = array_filter(explode(',', $configuredMethods));
        $shippingMethod = $order->getShippingMethod();

        foreach ($configuredMethods as $configuredMethod) {
            if (strpos($shippingMethod, $configuredMethod) === 0) {
                return true;
            }
        }

        return false;
    }
}
