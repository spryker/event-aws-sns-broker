<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\Creator;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;
use Spryker\Service\UtilText\Model\Url\Url;
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
     * @return void
     */
    public function createSubscribers(): void
    {
        foreach ($this->eventAwsSnsBrokerConfig->getEventBusNameToAwsSnsTopicArnMap() as $eventBusName => $topicArn) {
            $this->eventAwsSnsBrokerClient->createSubscriber(
                $topicArn,
                $this->getSubscriberEndpointByBusName($eventBusName),
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
        return Url::parse($this->eventAwsSnsBrokerConfig->getZedRequestBaseUrl())
            ->addPath('event-aws-sns-broker/event-handle')
            ->addQuery(EventHandleController::QUERY_PARAM_EVENT_BUS_NAME, $eventBusName)
            ->build();
    }
}
