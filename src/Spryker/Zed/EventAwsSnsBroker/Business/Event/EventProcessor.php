<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Event;

use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface;

class EventProcessor implements EventProcessorInterface
{
    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface
     */
    protected $eventTransferTransformer;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Dependency\Facade\EventAwsSnsBrokerToEventFacadeInterface
     */
    private $eventAwsSnsBrokerToEventFacade;

    /**
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface $eventTransferTransformer
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
            ->dispatch(
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

        return (new EventCollectionTransfer())
            ->addEvent($eventTransfer)
            ->setEventBusName($eventBusName);
    }
}
