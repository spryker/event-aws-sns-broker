<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Publisher;

use Generated\Shared\Transfer\EventCollectionTransfer;
use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Client\EventAwsSnsBroker\Exception\AwsSnsClientResponseException;
use Spryker\Shared\ErrorHandler\ErrorLogger;
use Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException;
use Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class EventPublisher implements EventPublisherInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface
     */
    protected $eventTransferTransformer;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\Business\Transformer\EventTransferTransformerInterface $eventTransferTransformer
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

        foreach ($eventCollectionTransfer->getEvents() as $eventTransfer) {
            try {
                $this->eventAwsSnsBrokerClient
                    ->publishEvent(
                        $topicArn,
                        $this->eventTransferTransformer->transformEventTransferIntoMessage($eventTransfer)
                    );
            } catch (AwsSnsClientResponseException $exception) {
                ErrorLogger::getInstance()->log($exception);
            }
        }
    }

    /**
     * @param string $eventBusName
     *
     * @throws \Spryker\Zed\EventAwsSnsBroker\Business\Exception\EventBusNameConfigException
     *
     * @return string
     */
    protected function getTopicArnByEventBusName(string $eventBusName): string
    {
        $topicNameTopicArnMap = $this->eventAwsSnsBrokerConfig->getEventBusNameToAwsSnsTopicArnMap();

        if (isset($topicNameTopicArnMap[$eventBusName])) {
            return $topicNameTopicArnMap[$eventBusName];
        }

        throw new EventBusNameConfigException('Requested event bus is not configured.');
    }
}
