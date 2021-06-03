<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Zed\EventAwsSnsBroker\Communication\Controller\EventHandleController;
use Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig;

class SubscriberCreator implements SubscriberCreatorInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @var \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig
     */
    protected $eventAwsSnsBrokerConfig;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     * @param \Spryker\Zed\EventAwsSnsBroker\EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
     */
    public function __construct(
        EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient,
        EventAwsSnsBrokerConfig $eventAwsSnsBrokerConfig
    ) {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
        $this->eventAwsSnsBrokerConfig = $eventAwsSnsBrokerConfig;
    }

    /**
     * @param string[] $eventBusNameTopicArnMap
     *
     * @return void
     */
    public function createSubscribers(array $eventBusNameTopicArnMap): void
    {
        foreach ($eventBusNameTopicArnMap as $eventBusName => $topicArn) {
            $endpoint = $this->getSubscriberEndpointByBusName($eventBusName);

            $this->eventAwsSnsBrokerClient->createSubscriber(
                $topicArn,
                $endpoint,
                $this->eventAwsSnsBrokerConfig->getAwsSnsProtocol()
            );
        }
    }

    /**
     * @param string $eventBusName
     *
     * @return string
     */
    protected function getSubscriberEndpointByBusName(string $eventBusName): string
    {
        return sprintf(
            '%s/%s?%s=%s',
            $this->eventAwsSnsBrokerConfig->getZedRequestBaseUrl(),
            'event-aws-sns-broker/event-handle',
            EventHandleController::QUERY_PARAM_EVENT_BUS_NAME,
            $eventBusName
        );
    }
}
