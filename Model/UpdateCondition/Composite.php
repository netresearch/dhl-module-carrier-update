<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Dhl\Paket\Model\UpdateCondition;

use Dhl\Paket\Api\UpdateConditionInterface;
use Magento\Sales\Api\Data\OrderInterface;

class Composite implements UpdateConditionInterface
{
    /**
     * @var UpdateConditionInterface[]
     */
    private $conditions;

    public function __construct(array $conditions = [])
    {
        $this->conditions = $conditions;
    }

    public function canUpdate(OrderInterface $order): bool
    {
        foreach ($this->conditions as $condition) {
            if (!$condition->canUpdate($order)) {
                return false;
            }
        }

        return true;
    }
}
