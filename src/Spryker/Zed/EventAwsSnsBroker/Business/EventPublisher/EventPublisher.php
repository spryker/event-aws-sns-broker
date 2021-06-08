<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\EventPublisher;

use Exception;
use Generated\Shared\Transfer\EventCollectionTransfer;
use RuntimeException;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Shared\ErrorHandler\ErrorLogger;
use Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

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
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\EventTransferTransformer\EventTransferTransformerInterface $eventTransferTransformer
     * @param \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
     */
    public function __construct(
        EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient,
        EventTransferTransformerInterface $eventTransferTransformer,
        EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
    ) {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
        $this->eventTransferTransformer = $eventTransferTransformer;
        $this->eventAwsSnsBrokerConfig = $eventAwsSnsBrokerConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\EventCollectionTransfer $eventCollectionTransfer
     *
     * @return void
     */
    public function publishEvents(EventCollectionTransfer $eventCollectionTransfer): void
    {
        $topicArn = $this->getTopicArnByEventBusName($eventCollectionTransfer->getEventBusNameOrFail());

        if (!$topicArn) {
            $exception = new RuntimeException('Requested event bus is not configured.');
            ErrorLogger::getInstance()->log($exception);

            return;
        }

        foreach ($eventCollectionTransfer->getEvents() as $eventTransfer) {
            try {
                $this->eventAwsSnsBrokerClient
                    ->publishEvent(
                        $topicArn,
                        $this->eventTransferTransformer->transformEventTransferIntoMessage($eventTransfer)
                    );
            } catch (Exception $exception) {
                ErrorLogger::getInstance()->log($exception);
            }
        }
    }

    /**
     * @param string $eventBusName
     *
     * @return string|null
     */
    protected function getTopicArnByEventBusName(string $eventBusName): ?string
    {
        $map = $this->eventAwsSnsBrokerConfig->getAwsSnsTopicArnMappedWithEventBusNames();

        return $map[$eventBusName] ?? null;
    }
}
