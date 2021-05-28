<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\EventAwsSnsBroker\Business\SubscriberCreator;

use Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface;

class SubscriberCreator implements SubscriberCreatorInterface
{
    /**
     * @var \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface
     */
    protected $eventAwsSnsBrokerClient;

    /**
     * @param \Spryker\Client\EventAwsSnsBroker\EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient
     */
    public function __construct(EventAwsSnsBrokerClientInterface $eventAwsSnsBrokerClient)
    {
        $this->eventAwsSnsBrokerClient = $eventAwsSnsBrokerClient;
    }

    /**
     * @param string[] $eventBusNames
     *
     * @return void
     */
    public function createSubscribers(array $eventBusNames): void
    {
        foreach ($eventBusNames as $eventBusName) {
            $topicArn = $this->getTopicArnByEventBusName($eventBusName);
            $endpoint = $this->getSubscriberEndpointByBusName($eventBusName);
            // todo::get $protocol from config
            $protocol = 'http';

            $subscriberArn = $this->eventAwsSnsBrokerClient->registerSubscriber($topicArn, $endpoint, $protocol);

            $this->saveSubscriberArn($topicArn, $eventBusName, $subscriberArn);
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

    /**
     * @param string $eventBusName
     *
     * @return string
     */
    protected function getSubscriberEndpointByBusName(string $eventBusName): string
    {
        // todo::generate $endpoint from ControllerHAndler action
        return 'http://zed.de.spryker.local/event-aws-sns-broker/handle-event/' . $eventBusName;
    }

    /**
     * @param string $eventBusName
     * @param string $topicArn
     * @param string $subscriberArn
     *
     * @return void
     */
    protected function saveSubscriberArn(string $eventBusName, string $topicArn, string $subscriberArn): void
    {
        // todo::save $subscriberArn into BD
    }
}
