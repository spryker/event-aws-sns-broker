<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Dependency\Facade;

use Generated\Shared\Transfer\EventCollectionTransfer;

interface EventAwsSnsBrokerToEventFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function dispatch(EventCollectionTransfer $eventCollectionTransfer): void;
}
