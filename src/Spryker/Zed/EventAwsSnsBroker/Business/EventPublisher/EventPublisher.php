<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher;

use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface;

class EventPublisher implements EventPublisherInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface
     */
    protected $eventTransferTransformer;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface $eventTransferTransformer
     */
    public function __construct(
        EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient,
        EventTransferTransformerInterface $eventTransferTransformer
    ) {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
        $this->eventTransferTransformer = $eventTransferTransformer;
    }

    /**
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $topicArn = $this->getTopicArnByEventBusName($eventCollectionTransfer->getEventBusNameOrFail());

        foreach ($eventCollectionTransfer->getEvents() as $eventTransfer) {
            $eventId = $this->eventAwsSnsBrokerClient
                ->publishEvent(
                    $topicArn,
                    $this->eventTransferTransformer->transformEventTransferIntoMessage($eventTransfer)
                );
            // todo:: do we need to do something with eventId.
        }
    }

    /**
     * @param string $eventBusName
     *
     * @return string
     */
    protected function getTopicArnByEventBusName(string $eventBusName): string
    {
        // todo::get $topicArn somewhere
        return 'arn:aws:sns:eu-central-1:000000000000:testHardCOdeddNmae12312';
    }
}
