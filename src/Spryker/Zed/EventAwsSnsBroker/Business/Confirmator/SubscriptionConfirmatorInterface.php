<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Confirmator;

use Generated\Shared\Transfer\SubscriptionConfirmationTransfer;

interface SubscriptionConfirmatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer
     *
     * @return bool
     */
    public function confirmSubscription(SubscriptionConfirmationTransfer $subscriptionConfirmationTransfer): bool;
}
