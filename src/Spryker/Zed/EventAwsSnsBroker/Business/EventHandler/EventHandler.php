<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\EventHandler;

use ArrayObject;
use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface;

class EventHandler implements EventHandlerInterface
{
    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface
     */
    protected $eventTransferTransformer;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface
     */
    private $eventAwsSnsBrokerToEventFacade;

    /**
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface $eventTransferTransformer
     * @param \Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface $eventAwsSnsBrokerToEventFacade
     */
    public function __construct(
        EventTransferTransformerInterface $eventTransferTransformer,
        EventAwsSnsBrokerToEventFacadeInterface $eventAwsSnsBrokerToEventFacade
    ) {
        $this->eventTransferTransformer = $eventTransferTransformer;
        $this->eventAwsSnsBrokerToEventFacade = $eventAwsSnsBrokerToEventFacade;
    }

    /**
     * @param string $eventMessage
     * @param string $eventBusName
     *
     * @return void
     */
    public function handleEvent(string $eventMessage, string $eventBusName): void
    {
        $this->eventAwsSnsBrokerToEventFacade
            ->dispatchEvents(
                $this->prepareEventCollectionTransfer($eventMessage, $eventBusName)
            );
    }

    /**
     * @param string $eventMessage
     * @param string $eventBusName
     *
     * @return \Generated\Shared\Transfer\EventCollectionTransfer
     */
    protected function prepareEventCollectionTransfer(string $eventMessage, string $eventBusName): EventCollectionTransfer
    {
        $eventTransfer = $this->eventTransferTransformer->transformMessageIntoEventTransfer($eventMessage);
        $events = new ArrayObject();
        $events->append($eventTransfer);

        $eventCollectionTransfer = new EventCollectionTransfer();
        $eventCollectionTransfer->setEvents($events);
        $eventCollectionTransfer->setEventBusName($eventBusName);

        return $eventCollectionTransfer;
    }
}
