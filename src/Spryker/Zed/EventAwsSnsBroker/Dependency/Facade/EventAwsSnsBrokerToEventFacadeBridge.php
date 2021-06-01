<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Dependency\Facade;

use Generated\Shared\Transfer\EventCollectionTransfer;

class EventAwsSnsBrokerToEventFacadeBridge implements EventAwsSnsBrokerToEventFacadeInterface
{
    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    private $eventFacade;

    /**
     * @param \Spryker\Zed\Event\Business\EventFacadeInterface $eventFacade
     */
    public function __construct($eventFacade)
    {
        $this->eventFacade = $eventFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function dispatchEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $this->eventFacade->dispatch($eventCollectionTransfer);
    }
}
